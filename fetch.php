<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 18/11/2557
 * Time: 10:24 น.
 */

require_once 'bootstrap.php';

$i = 1;
while($i != 0){
    $i = \Main\Helper\GeneralHelper::curl_post(\Main\Helper\GeneralHelper::host_url()."/api.php?".http_build_query(array(
        "ctl"=> "QueCTL",
        "method"=> "hideBySetting",
        "max"=> 5
    )));
    echo json_encode($i)."\n";
}