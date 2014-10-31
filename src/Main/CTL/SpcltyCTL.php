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
}