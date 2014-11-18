<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 28/10/2557
 * Time: 16:51 น.
 */

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

date_default_timezone_set('Asia/Bangkok');

require_once 'vendor/autoload.php';
require_once 'src/Main/Autoloader.php';

\Main\Autoloader::register();
