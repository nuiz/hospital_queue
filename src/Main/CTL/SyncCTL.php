<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 31/10/2557
 * Time: 11:52 น.
 */

namespace Main\CTL;


use Main\DB;
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
}