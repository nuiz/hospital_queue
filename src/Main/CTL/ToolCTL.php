<?php
/**
 * Created by PhpStorm.
 * User: Papangping
 * Date: 11/14/14
 * Time: 6:29 AM
 */

namespace Main\CTL;


use Main\DB;

class ToolCTL extends BaseCTL {
    public function clearTable($className){
        $em = DB::queEM();
        $cmd = $em->getClassMetadata($className);
        $connection = $em->getConnection();
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
    }

    public function clearQue(){
        $this->clearTable('Main\Entity\Que\CallQue');
        $this->clearTable('Main\Entity\Que\Que');

        $queEM = DB::queEM();
        $hosEM = DB::hosEM();

        $queEM->clear();
        $hosEM->clear();

        $json = array(
            'publish'=> array(
                'name'=> 'clear',
                'data'=> array('success'=> true)
            )
        );

        $wsClient = new \Main\Socket\Client\WsClient("localhost", 8081);
        $wsClient->sendData(json_encode($json));
    }

    public function hideAll(){
        $em = DB::queEM();
        $qb = $em->getRepository('Main\Entity\Que\Que')->createQueryBuilder('a');
        $qb->where('a.is_hide=0');

        $q = $qb->getQuery();

        /** @var \Main\Entity\Que\Que[] $items */
        $items = $q->getResult();

        foreach($items as $item){
            if($item->getIsHide()){
                continue;
            }

            $item->setIsHide(true);
            $em->merge($item);
            $em->flush();

            $json = array(
                'publish'=> array(
                    'name'=> 'hide',
                    'data'=> $item
                )
            );

            $wsClient = new \Main\Socket\Client\WsClient("localhost", 8081);
            $wsClient->sendData(json_encode($json));
        }
    }
}