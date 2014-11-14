<?php
/**
 * Created by PhpStorm.
 * User: Papangping
 * Date: 11/14/14
 * Time: 4:58 AM
 */

namespace Main\CTL;


use Main\DB;
use Main\Entity\Que\Setting;

class SettingCTL extends BaseCTL {
    public function getEntity(){
        $queEM = DB::queEM();
        $item = $queEM->getRepository('Main\Entity\Que\Setting')->findOneBy(array());
        if(is_null($item)){
            copy("default/background.jpg", 'picture/background.jpg');
            $item = new Setting();
            $item->setBackgroundPath('picture/background.jpg');
            $item->setShowPeopleName(true);

            $queEM->persist($item);
            $queEM->flush();
        }

        return $item;
    }

    public function get(){
        return $this->getEntity();
    }

    public function edit(){
        $queEM = DB::queEM();
        $item = $this->getEntity();
        if(isset($this->param['background'])){
            $name = $this->param['background']['name'];
            $ext = array_pop(explode('.', $name));

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
        if(isset($this->param['show_people_name'])){
            $item->setShowPeopleName((bool)$this->param['show_people_name']);
        }

        $queEM->merge($item);
        $queEM->flush();

        return $this->getEntity();
    }
} 