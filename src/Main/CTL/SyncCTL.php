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
        $cmd = $queEM->getClassMetadata('Main\Entity\Hos\Spclty');
        $connection = $queEM->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->beginTransaction();

        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
            $connection->executeUpdate($q);
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
        }
        catch (\Exception $e) {
            $connection->rollback();
        }

        // sync table
        $items = $hosEM->getRepository('Main\Entity\Hos\Spclty')->findAll();

        $queEM->beginTransaction();
        foreach($items as $key=> $value){
            /** @var \Main\Entity\Hos\Spclty $value */
            $item = new Spclty();
            $item->setName($value->getName());
            $item->setDepcode($value->getDepcode());
            $item->setShortname($value->getShortname());
            $item->setSpclty($value->getSpclty());
            $item->setSpname($value->getSpname());

            $queEM->persist($item);
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

        $hosEM->clear();

        $lastQue = $queEM->getRepository('Main\Entity\Que\Que')->findOneBy(array(), array('vstdate'=> 'DESC', 'vsttime'=> 'DESC'));

        // sync table
        $qb = $hosEM->getRepository('Main\Entity\Hos\Ovst')->createQueryBuilder("a");
        $qb->select("a")->setMaxResults(50);

        if(!is_null($lastQue)){
//            $qb->where("a.vstdate > :vstdate")->andWhere("a.vsttime > :vsttime")
//                ->setParameter(':vstdate', /*$lastQue->getVstdate()->format("Y-m-d")*/ "2014-11-13")
//                ->setParameter(':vsttime', /*$lastQue->getVsttime()->format("H:i:s")*/ "14:17:33");
            $qb->where("a.vn > :vn")
                ->setParameter(':vn', $lastQue->getVn());
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
            $wsClient->sendData($json);
            unset($wsClient);
            unset($patient);

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