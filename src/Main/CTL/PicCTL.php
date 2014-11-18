<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 18/11/2557
 * Time: 10:58 น.
 */

namespace Main\CTL;


use Main\DB;

class PicCTL extends BaseCTL {
    public function displayByHn(){
        $hosEM = DB::hosEM();

        /** @var \Main\Entity\Hos\PatientImage $item */
        $item = $hosEM->getRepository('Main\Entity\Hos\PatientImage')->find($this->param['hn']);

        if(!is_null($item)){
//            $file = $item->getImage();
//            $response = new \Symfony\Component\HttpFoundation\Response(stream_get_contents($file), 200, array(
//                'Content-Type' => 'image/jpeg',
//                'Content-Length' => sizeof($file)
//            ));
//
//            $response->send();
            $type = mime_content_type($item->getImage());
            header('Content-Type: '.$type);

            echo stream_get_contents($item->getImage());
            exit();
        }
    }
} 