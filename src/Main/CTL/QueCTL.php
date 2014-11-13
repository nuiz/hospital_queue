<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 13/11/2557
 * Time: 1:06 น.
 */

namespace Main\CTL;


use Main\DB;

class QueCTL extends BaseCTL {
    public function getAll(){
        $queEM = DB::queEM();
        $items = $queEM->getRepository('Main\Entity\Que\Que')->findAll();

        return $items;
    }

    public function gets(){
        $queEM = DB::queEM();
        $qb = $queEM->getRepository('Main\Entity\Que\Que')->createQueryBuilder("a");
        $qb->where("a.is_skip = 0");
        $items = $qb->getQuery()->getResult();

        return $items;
    }

    public function skip(){
        $queEM = DB::queEM();

        /** @var \Main\Entity\Que\Que $item */
        $item = $queEM->getRepository('Main\Entity\Que\Que')->findOneBy(array(
            'id'=> $this->param['id']
        ));

        if(!is_null($item)){
            $item->setIsSkip(true);
            $queEM->persist($item);
            $queEM->flush();

            $wsClient = new \Main\Socket\Client\WsClient("localhost", 8081);

            $json = array(
                'publish'=> array(
                    'name'=> 'skip',
                    'data'=> $item
                )
            );
            $wsClient->sendData(json_encode($json));
            unset($wsClient);
            unset($patient);
        }

        return $item;
    }
} 