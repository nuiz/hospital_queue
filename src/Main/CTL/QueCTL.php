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
        $queEM->clear();

        $qb = $queEM->getRepository('Main\Entity\Que\Que')->createQueryBuilder("a");
        $qb->where("a.is_skip = 0")->orderBy('a.vstts');
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
            $queEM->merge($item);
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
        }

        return $item;
    }

    public function hide(){
        $queEM = DB::queEM();
        /** @var \Main\Entity\Que\Que $item */
        $item = $queEM->getRepository('Main\Entity\Que\Que')->findOneBy(array(
            'id'=> $this->param['id']
        ));

        if(!is_null($item)){
            $item->setIsHide((bool)$this->param['is_hide']);
            $queEM->merge($item);
            $queEM->flush();

            $wsClient = new \Main\Socket\Client\WsClient("localhost", 8081);

            $json = array(
                'publish'=> array(
                    'name'=> 'hide',
                    'data'=> $item
                )
            );
            $wsClient->sendData(json_encode($json));
            unset($wsClient);
        }

        return $item;
    }

    public function editNote(){
        $queEM = DB::queEM();
        /** @var \Main\Entity\Que\Que $item */
        $item = $queEM->getRepository('Main\Entity\Que\Que')->findOneBy(array(
            'id'=> $this->param['id']
        ));

        if(!is_null($item)){
            $item->setNote($this->param['note']);
            $queEM->merge($item);
            $queEM->flush();

            $wsClient = new \Main\Socket\Client\WsClient("localhost", 8081);

            $json = array(
                'publish'=> array(
                    'name'=> 'editNote',
                    'data'=> $item
                )
            );
            $wsClient->sendData(json_encode($json));
            unset($wsClient);
        }

        return $item;
    }

    public function searchByHn(){
        $hosEM = DB::hosEM();

        /** @var \Main\Entity\Hos\Patient $item */
        $item = $hosEM->getRepository('Main\Entity\Hos\Patient')->findOneBy(array(
            'hn'=> $this->param['hn']
        ));
        $settingCTL = new SettingCTL();
        $setting = $settingCTL->get();

        return array('item'=> $item, 'setting'=> $setting);
    }

    public function hideBySetting(){
        $queEM = DB::queEM();

        $settingCTL = new SettingCTL();
        $setting = $settingCTL->get();

        /** @var \Main\Entity\Que\Que $item */
        $qb = $queEM->getRepository('Main\Entity\Que\Que')->createQueryBuilder("a");
        $qb->where("a.is_hide = 0")->andWhere("a.vstts < :vstts")->orderBy('a.vstts');
        $qb->setParameter('vstts', time() - ($setting->getAutoHideTime()*60));

        $res = 0;
        $items = $qb->getQuery()->getResult();
        foreach($items as $key=> $item){
            $item->setIsHide(true);
            $queEM->merge($item);
            $queEM->flush();

            $wsClient = new \Main\Socket\Client\WsClient("localhost", 8081);

            $json = array(
                'publish'=> array(
                    'name'=> 'hide',
                    'data'=> $item
                )
            );
            $wsClient->sendData(json_encode($json));
            unset($wsClient);

            $res++;
        }

        return $res;
    }

    public function fetchDrug(){
        $last_drug = file_get_contents('cache/last_drug.txt');

        $queEM = DB::queEM();
        $hosEM = DB::hosEM();

        $qb = $hosEM->getRepository('Main\Entity\Hos\Opitemrece')->createQueryBuilder("a");
        $qb->select("a");

        if($last_drug == 0){
            $qb->where("a.rxdate = :rxdate")
                ->setParameter(':rxdate', date("Y-m-d"))
                ->orderBy("a.rxtime");
        }
        else {
            $qb->where("a.rxdate = :rxdate")
                ->andWhere("a.rxtime > :rxtime")
                ->setParameter(':rxdate', date("Y-m-d"))
                ->setParameter(':rxtime', date("H:i:s", $last_drug))
                ->orderBy("a.rxtime");
        }

        $q = $qb->getQuery();

        /** @var \Main\Entity\Hos\Opitemrece[] $items */
        $items = $q->getResult();

        $qb = $hosEM->getRepository('Main\Entity\Hos\Opitemrece')->createQueryBuilder('a');
        $qb->select("MAX(a.rxtime)");
        $maxRxtime = $qb->getQuery()->getSingleScalarResult();
        $last_drug = strtotime($maxRxtime);

        $res = 0;
        $vnCount = array();
        foreach($items as $key=> $value){
            /** @var \Main\Entity\Que\Que $que */
            $que = $queEM->getRepository('Main\Entity\Que\Que')->findOneBy(array(
                'vn'=> $value->getVn()
            ));

            if(!is_null($que)){
                if(!isset($vnCount[$que->getVn()])){
                    $qb = $hosEM->getRepository('Main\Entity\Hos\Opitemrece')->createQueryBuilder('a');
                    $qb->select("COUNT(a)")->where("a.vn = :vn")->setParameter(':vn', $que->getVn());
                    $count = $qb->getQuery()->getSingleScalarResult();

                    $vnCount[$que->getVn()] = $count;
                }

                $que->setDrug($vnCount[$que->getVn()]);
                $que->setSpclty("21");

                $queEM->merge($que);
                $queEM->flush();

                $wsClient = new \Main\Socket\Client\WsClient("localhost", 8081);

                $json = array(
                    'publish'=> array(
                        'name'=> 'drug',
                        'data'=> $que
                    )
                );

                $wsClient->sendData(json_encode($json));
                unset($wsClient);
            }

            $res++;
        }

        file_put_contents('cache/last_drug.txt', $last_drug);
        return $res;
    }

    public function syncDrug(){
        $queEM = DB::queEM();
        $hosEM = DB::hosEM();

        /** @var \Main\Entity\Que\Que $item */
        $item = $queEM->getRepository('Main\Entity\Que\Que')->find($this->param['id']);

        if(!is_null($item)){
            $qb = $hosEM->getRepository('Main\Entity\Hos\Opitemrece')->createQueryBuilder('a');
            $qb->select("COUNT(a)")->where("a.vn = :vn")->setParameter(':vn', $item->getVn());
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
        }

        return $item;
    }
}