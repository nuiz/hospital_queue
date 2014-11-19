<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 6/23/14
 * Time: 3:37 AM
 */

namespace Main\CTL;


use Main\DB;

class CallCTL extends BaseCTL {
    public function call(){
        $queEM = DB::queEM();

        $call = new \Main\Entity\Que\CallQue();
        $call->setHn($this->param['hn']);
        $call->setFname($this->param['fname']);
        $call->setLname($this->param['lname']);
        $call->setPrefix1Id($this->param['prefix1_id']);
        $call->setPrefix2Id($this->param['prefix2_id']);
        $call->setPrefix3Id($this->param['prefix3_id']);

        $spclty = isset($this->param['spclty'])? $this->param['spclty']: null;
        $call->setSpclty($spclty);

        $queEM->persist($call);
        $queEM->flush();

        $wsClient = new \Main\Socket\Client\WsClient("localhost", 8081);

        $json = array(
            'publish'=> array(
                'name'=> 'call',
                'data'=> $call
            )
        );

        $wsClient->sendData(json_encode($json));
        unset($wsClient);
        unset($patient);

        $settingCTL = new SettingCTL();
        $setting = $settingCTL->get();
        if($setting->getSkipAfterCall()){
            $condition = array("hn"=> $this->param["hn"]);
            if(!is_null($spclty)){
                $condition['spclty'] = $spclty;
            }

            /** @var \Main\Entity\Que\Que $item */
            $item = $queEM->getRepository('Main\Entity\Que\Que')->findOneBy($condition);

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

                return $json;
            }
        }
        unset($settingCTL);
        unset($setting);

        return $call;
    }
}