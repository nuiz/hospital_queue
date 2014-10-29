<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 28/10/2557
 * Time: 16:51 น.
 */

require_once 'bootstrap.php';
header('Content-type: application/json');

$methodName = $_GET['method'];
$ctlName = $_GET['ctl'];

$fullCTL = '\Main\CTL\\'.$ctlName;
$ctl = new $fullCTL();
$ctl->init($_POST);
$res = $ctl->{$methodName}();
echo json_encode($res);