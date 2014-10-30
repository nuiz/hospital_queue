<?php
/**
 * Created by PhpStorm.
 * User: Papangping
 * Date: 10/26/14
 * Time: 9:49 PM
 */

$action = isset($_GET['action'])? $_GET['action']: 'main';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hospital Queue</title>

    <link rel="stylesheet" href="css/main.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="js/jquery.isloading.min.js"></script>
</head>
<body>
<!-- Fixed navbar -->
<div class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">Hospital Queue</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="<?php if($action=="main") echo "active";?>"><a href="index.php?action=main">Main</a></li>
                <li class="<?php if($action=="sound") echo "active";?>"><a href="index.php?action=sound">Sound</a></li>
                <li class="<?php if($action=="setting") echo "active";?>"><a href="index.php?action=setting">Setting</a></li>
                <li class="<?php if($action=="dep") echo "active";?>"><a href="index.php?action=dep">Department</a></li>
                <li class="<?php if($action=="tools") echo "active";?>"><a href="index.php?action=tools">Tools</a></li>
            </ul>
<!--            <ul class="nav navbar-nav navbar-right">-->
<!--                <li><a href="#">Link</a></li>-->
<!--                <li><a href="#">Link</a></li>-->
<!--                <li><a href="#">Link</a></li>-->
<!--            </ul>-->
        </div><!--/.nav-collapse -->
    </div>
</div>
<div class="container">
<?php
include("view/".$action.".php");
?>
</div>
</body>
</html>