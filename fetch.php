<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 18/11/2557
 * Time: 10:24 น.
 */

require_once 'bootstrap.php';

while(
\Main\Helper\GeneralHelper::curl_post(\Main\Helper\GeneralHelper::host_url()."/api.php?".http_build_query(array(
    "ctl"=> "QueCTL",
    "method"=> "hideBySetting"
))) == 0);