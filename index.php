<?php
// key = E0B35-03804-68D73-C848B-96B12
require_once 'bootstrap.php';
require_once 'src/Main/Helper/Checksum.php';

$action = isset($_GET['action'])? $_GET['action']: 'main';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hospital Queue</title>

    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/jquery-migrate-1.2.1.min.js"></script>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="css/bootstrap-theme.min.css">-->
    <link rel="stylesheet" href="css/docs.css">
    <link rel="stylesheet" href="bootflat/css/bootflat.min.css">
    <link rel="stylesheet" href="css/main.css">

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.isloading.min.js"></script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <script src="bootflat/js/icheck.min.js"></script>
    <script src="bootflat/js/jquery.fs.selecter.min.js"></script>
    <script src="bootflat/js/jquery.fs.stepper.min.js"></script>
</head>
<body style="background: #f1f1f1;">

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
            <a href="index.php?action=main" class="navbar-brand">Hospital Queue</a>
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
    <div class="bs-callout bs-callout-info bg-white">
        <h4>Hospital Queue</h4>
        <p>
            <span class="label label-default">v1.0</span>
            <span class="label label-default">copyright by MRG- , Papangping</span>
            <?php
            $option = new stdClass();
            $option->version = 1.0; // Application Version

            $checksum = new Checksum($option);
            if ($checksum->check("E0B35-03804-68D73-C848B-96B12")) {
                echo <<<HTML
                <span class="label label-info">license is valid</span>
HTML;
            } else {
                echo <<<HTML
                <span class="label label-danger">license not valid</span>
HTML;
            }
            ?>
        </p>
    </div>
</div>

</body>
</html>