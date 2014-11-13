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
        $call->setPrefix1Path($this->param['prefix1_path']);
        $call->setPrefix2Path($this->param['prefix2_path']);
        $call->setPrefix3Path($this->param['prefix3_path']);

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