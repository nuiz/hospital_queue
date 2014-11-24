<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 31/10/2557
 * Time: 11:52 น.
 */

namespace Main\CTL;


use Main\DB;
use Main\Entity\Que\Que;
use Main\Entity\Que\Spclty;
use Ratchet\Wamp\Exception;

class SyncCTL extends BaseCTL {
    public function spclty(){
        $queEM = DB::queEM();
        $hosEM = DB::hosEM();

        // truncate table
//        $cmd = $queEM->getClassMetadata('Main\Entity\Hos\Spclty');
//        $connection = $queEM->getConnection();
//        $dbPlatform = $connection->getDatabasePlatform();
//        $connection->beginTransaction();
//
//        try {
//            $connection->query('SET FOREIGN_KEY_CHECKS=0');
//            $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
//            $connection->executeUpdate($q);
//            $connection->query('SET FOREIGN_KEY_CHECKS=1');
//            $connection->commit();
//        }
//        catch (\Exception $e) {
//            $connection->rollback();
//        }

        // sync table
        /** @var \Main\Entity\Hos\Spclty[] $items */
        $items = $hosEM->getRepository('Main\Entity\Hos\Spclty')->findAll();

        $queEM->beginTransaction();
        foreach($items as $key=> $value){
            $item = $queEM->getRepository('Main\Entity\Que\Spclty')->find($value->getSpclty());

            if(is_null($item)){
                $item = new Spclty();
                $item->setName($value->getName());
                $item->setDepcode($value->getDepcode());
                $item->setShortname($value->getShortname());
                $item->setSpclty($value->getSpclty());
                $item->setSpname($value->getSpname());

                $queEM->persist($item);
            }
            else {
                $item->setName($value->getName());
                $item->setDepcode($value->getDepcode());
                $item->setShortname($value->getShortname());
                $item->setSpclty($value->getSpclty());
                $item->setSpname($value->getSpname());

                $queEM->merge($item);
            }
        }

        // flush
        try {
            $queEM->flush();
            $queEM->commit();
        }
        catch(Exception $ex){
            $queEM->rollback();
        }
        return true;
    }

    public function que(){
        $queEM = DB::queEM();
        $hosEM = DB::hosEM();

        $max = isset($this->param['max'])? $this->param['max']: 10;

        $hosEM->clear();

        $lastQue = $queEM->getRepository('Main\Entity\Que\Que')->findOneBy(array(), array('vsttime'=> 'DESC'));

        // sync table
        $qb = $hosEM->getRepository('Main\Entity\Hos\Ovst')->createQueryBuilder("a");
        $qb->select("a")->setMaxResults($max);

        if(is_null($lastQue)){
            $qb->where("a.vstdate = :vstdate")
                ->setParameter(':vstdate', date("Y-m-d"))
                ->orderBy("a.vsttime");
        }
        else {
            // if found last && last not today >> clear que
            if(strtotime($lastQue->getVstdate()->format("Y-m-d")) < strtotime(date("Y-m-d"))){
                $toolCTL = new ToolCTL();
                $toolCTL->clearQue();
            }

            $qb->where("a.vstdate = :vstdate")
                ->andWhere("a.vsttime > :vsttime")
                ->setParameter(':vstdate', date("Y-m-d"))
                ->setParameter(':vsttime', $lastQue->getVsttime()->format("H:i:s"))
                ->orderBy("a.vsttime");
        }

        $q = $qb->getQuery();

        $items = $q->getResult();

        $queEM->beginTransaction();

        $res = 0;

        /** @var \Main\Entity\Hos\Ovst $value */
        foreach($items as $key=> $value){
            /** @var \Main\Entity\Hos\Patient $patient */
            $patient = $hosEM->getRepository('Main\Entity\Hos\Patient')->findOneBy(array(
                'hn'=> $value->getHn()
            ));

            if(is_null($patient)) continue;

            $item = new Que();
            $item->setHn($value->getHn());
            $item->setSpclty($value->getSpclty());
            $item->setVn($value->getVn());

            $item->setVstdate($value->getVstdate());
            $item->setVsttime($value->getVsttime());
            $item->setVstts($value->getVsttime()->getTimestamp());

            $item->setFname($patient->getFname());
            $item->setLname($patient->getLname());

            $queEM->persist($item);

            $wsClient = new \Main\Socket\Client\WsClient("localhost", 8081);

            $json = json_encode(array(
                'publish'=> array(
                    'name'=> 'add',
                    'data'=> $item
                )
            ));

            // name sound
            $firstname_path = 'sound/google/'.base64_encode($item->getFname()).'.mp3';
            $lastname_path = 'sound/google/'.base64_encode($item->getLname()).'.mp3';

            $firstname_len = @file_get_contents($firstname_path);
            if (!is_file($firstname_path) || strlen($firstname_len)===0) {
                $lang = preg_match('/[ก-๙]/i', $item->getFname())? 'th': 'en';
                $fcontent = file_get_contents("http://translate.google.com/translate_tts?tl={$lang}&ie=UTF-8&q=".urlencode(trim($item->getFname())));
                $fp = fopen($firstname_path, 'w');
                fwrite($fp, $fcontent);
                fclose($fp);

                unset($fcontent);
                unset($fp);
            }

            $lastname_len = @file_get_contents($lastname_path);
            if (!is_file($lastname_path) || strlen($lastname_len)===0) {
                $lang = preg_match('/[ก-๙]/i', $item->getLname())? 'th': 'en';
                $lcontent = file_get_contents("http://translate.google.com/translate_tts?tl={$lang}&ie=UTF-8&q=".urlencode(trim($item->getLname())));
                $fp = fopen($lastname_path, 'w');
                fwrite($fp, $lcontent);
                fclose($fp);

                unset($lcontent);
                unset($fp);
            }

            $wsClient->sendData($json);
            unset($wsClient);
            unset($patient);

            // sync drug

            $qb = $hosEM->getRepository('Main\Entity\Hos\Opitemrece')->createQueryBuilder('a');
            $qb->select("COUNT(a)")->where("a.hn = :hn")->setParameter(':hn', $item->getHn());
            $count = $qb->getQuery()->getSingleScalarResult();
            $item->setDrug((int)$count);

            $queEM->merge($item);
            $queEM->flush();

            $wsClient = new \Main\Socket\Client\WsClient("localhost", 8081);

            $json = array(
                'publish'=> array(
                    'name'=> 'drug',
                    'data'=> $item
                )
            );
            $wsClient->sendData(json_encode($json));
            unset($wsClient);

            $res++;
        }

        // flush
        try {
            $queEM->flush();
            $queEM->commit();
        }
        catch(Exception $ex){
            $queEM->rollback();
        }

        return $res;
    }
}