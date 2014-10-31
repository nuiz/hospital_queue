<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 28/10/2557
 * Time: 17:05 น.
 */

namespace Main\CTL;


use Main\DB;
use Main\Entity\Que\SoundPrefix1;
use Main\Entity\Que\SoundPrefix2;
use Main\Entity\Que\SoundPrefix3;
use Main\Helper\ResponseHelper;
use Ratchet\Wamp\Exception;

class SoundCTL extends BaseCTL {
    public function add(){
        $queEM = DB::queEM();
        $queEM->beginTransaction();
        try {
            // create entity
            if($this->param['prefix']=='1'){
                $sp = new SoundPrefix1();
            }
            else if($this->param['prefix']=='2'){
                $sp = new SoundPrefix2();
            }
            else if($this->param['prefix']=='3'){
                $sp = new SoundPrefix3();
            }
            else {
                throw new Exception();
            }
            $sp->setName($this->param['name']);

            // path
            $fileName = uniqid().time();
            $path = "sound/prefix/".$fileName.'.mp3';

            $lang = 'th';
            if(!preg_match('/[ก-๙]/i', $this->param['name'])){
                $lang = 'en';
            }
            $soundData = file_get_contents("http://translate.google.com/translate_tts?tl={$lang}&ie=UTF-8&q=".urlencode($this->param['name']));
            $fp = fopen($path, 'w');
            fwrite($fp, $soundData);
            fclose($fp);

            $sp->setPath($path);

            $queEM->persist($sp);
            $queEM->flush();
            $queEM->commit();

            return $sp->toArray();
        }
        catch (Exception $ex) {
            @unlink($path);
            $queEM->rollback();
            return ResponseHelper::error("Add sound error.");
        }
    }

    public function remove(){
        $queEM = DB::queEM();
        $queEM->beginTransaction();
        try {
            // create entity
            if($this->param['prefix']=='1'){
                $eName = 'Main\Entity\Que\SoundPrefix1';
            }
            else if($this->param['prefix']=='2'){
                $eName = 'Main\Entity\Que\SoundPrefix2';
            }
            else if($this->param['prefix']=='3'){
                $eName = 'Main\Entity\Que\SoundPrefix3';
            }
            else {
                throw new Exception();
            }
            $entity = $queEM->getRepository($eName)->findOneBy(array('id' => $this->param['id']));
            $path = $entity->getPath();
            $queEM->remove($entity);
            $queEM->flush();
            $queEM->commit();

            @unlink($path);
            return true;
        }
        catch (Exception $ex) {
            $queEM->rollback();
            return ResponseHelper::error("Add sound error.");
        }
    }

    public function gets(){
        $queEM = DB::queEM();
        try {
            if($this->param['prefix']=='1'){
                $eName = 'Main\Entity\Que\SoundPrefix1';
            }
            else if($this->param['prefix']=='2'){
                $eName = 'Main\Entity\Que\SoundPrefix2';
            }
            else if($this->param['prefix']=='3'){
                $eName = 'Main\Entity\Que\SoundPrefix3';
            }
            else {
                throw new Exception();
            }
            $qb = $queEM->getRepository($eName)->createQueryBuilder('a');
            $qb->orderBy('a.created_at');
            $q = $qb->getQuery();
            $items = $q->getResult();

            $res = array();
            foreach($items as $key=> $value){
                $res[] = $value->toArray();
            }

            return $res;
        }
        catch (Exception $ex){
            return ResponseHelper::error("Error");
        }
    }

    public function getsAllPrefix(){
        $resAll = array();
        $queEM = DB::queEM();
        $this->param['prefix'] = '1';
        $resAll['prefix1'] = $this->gets();
        $this->param['prefix'] = '2';
        $resAll['prefix2'] = $this->gets();
        $this->param['prefix'] = '3';
        $resAll['prefix3'] = $this->gets();

        return $resAll;
    }
}