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
        $queEm = DB::queEM();

        $call = new \Main\Entity\Que\CallQue();
        $call->setFname($this->param['fname']);
        $call->setLname($this->param['lname']);
        $call->setPrefix1Id($this->param['prefix1_id']);
        $call->setPrefix2Id($this->param['prefix2_id']);
        $call->setPrefix3Id($this->param['prefix3_id']);
        $call->setSpclty($this->param['spclty']);

        $queEm->persist($call);
        $queEm->flush();

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

        return $call;
    }
}