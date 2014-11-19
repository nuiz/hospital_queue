<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 13/11/2557
 * Time: 14:12 น.
 */

require_once 'bootstrap.php';

$i = 1;
while($i != 0){
    $i = \Main\Helper\GeneralHelper::curl_post(\Main\Helper\GeneralHelper::host_url()."/api.php?".http_build_query(array(
        "ctl"=> "SyncCTL",
        "method"=> "que"
    )));
    echo json_encode($i)."\n";
}