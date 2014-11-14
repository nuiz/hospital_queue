<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 31/10/2557
 * Time: 11:16 น.
 */

namespace Main\CTL;


use Main\DB;
use Main\Entity\Que\Spclty;

class SpcltyCTL extends BaseCTL {
    /**
     * @return Spclty[]
     */
    public function gets(){
        $queEM = DB::queEM();
        $items = $queEM->getRepository('Main\Entity\Que\Spclty')->findAll();
        return $items;
    }

    public function edit(){
        $queEM = DB::queEM();
        $item = $queEM->getRepository('Main\Entity\Que\Spclty')->findOneBy(array('id'=> $this->param['id']));
        if(!is_null($item)){
            if(isset($this->param['background'])){
                $name = $this->param['background']['name'];
                $ext = explode('.', $name);
                $ext = array_pop($ext);

                $allow = array("jpg", "jpeg", "png");
                if(!in_array($ext, $allow)){
                    return array(
                        'error'=> array(
                            'message'=> 'Not allow extension'
                        )
                    );
                }

                $des = 'picture/'.uniqid().'.'.$ext;
                move_uploaded_file($this->param['background']['tmp_name'], $des);

                @unlink($item->getBackgroundPath());

                $item->setBackgroundPath($des);
            }

            $queEM->merge($item);
            $queEM->flush();
        }
        return $item;
    }
}