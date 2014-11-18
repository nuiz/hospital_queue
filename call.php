<?php
require_once 'bootstrap.php';
$queEM = \Main\DB::queEM();

/** @var Main\Entity\Que\CallQue $call */
$call = $queEM->getRepository('Main\Entity\Que\CallQue')->find($_GET['id']);
/** @var Main\Entity\Que\Setting $setting */
$setting = $queEM->getRepository('Main\Entity\Que\Setting')->findOneBy(array());
/** @var Main\Entity\Que\Spclty $spclty */
$spclty = $queEM->getRepository('Main\Entity\Que\Spclty')->findOneBy(array('spclty'=> $call->getSpclty()));

/** @var Main\Entity\Que\SoundPrefix1 $prefix1 */
$prefix1 = $queEM->getRepository('Main\Entity\Que\SoundPrefix1')->find($call->getPrefix1Id());
/** @var Main\Entity\Que\SoundPrefix2 $prefix2 */
$prefix2 = $queEM->getRepository('Main\Entity\Que\SoundPrefix2')->find($call->getPrefix2Id());
/** @var Main\Entity\Que\SoundPrefix3 $prefix3 */
$prefix3 = $queEM->getRepository('Main\Entity\Que\SoundPrefix3')->find($call->getPrefix3Id());

if(is_null($spclty) || is_null($spclty->getBackgroundPath())){
    $bgUrl = $setting->getBackgroundPath();
}
else {
    $bgUrl = $spclty->getBackgroundPath();
}

if($setting->getShowPeoplePicture()){
    $hnUrl = "api.php?ctl=PicCTL&method=displayByHn&hn=".$call->getHn();
}
else {
    $hnUrl = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjcwIiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE0MHgxNDA8L3RleHQ+PC9zdmc+";
}

// name sound
$firstname_path = 'sound/google/'.base64_encode($call->getFname()).'.mp3';
$lastname_path = 'sound/google/'.base64_encode($call->getLname()).'.mp3';

$firstname_len = @file_get_contents($firstname_path);
if (!is_file($firstname_path) || strlen($firstname_len)===0) {
    $lang = preg_match('/[ก-๙]/i', $call->getFname())? 'th': 'en';
    $fcontent = file_get_contents("http://translate.google.com/translate_tts?tl={$lang}&ie=UTF-8&q=".urlencode(trim($call->getFname())));
//    $fp = fopen($firstname_path, 'w');
//    fwrite($fp, $fcontent);
//    fclose($fp);
    file_put_contents($firstname_path, $fcontent);
}

$lastname_len = @file_get_contents($lastname_path);
if (!is_file($lastname_path) || strlen($lastname_len)===0) {
    $lang = preg_match('/[ก-๙]/i', $call->getLname())? 'th': 'en';
    $lcontent = file_get_contents("http://translate.google.com/translate_tts?tl={$lang}&ie=UTF-8&q=".urlencode(trim($call->getLname())));
//    $fp = fopen($lastname_path, 'w');
//    fwrite($fp, $lcontent);
//    fclose($fp);
    file_put_contents($lastname_path, $lcontent);
}

// name sound
$lang = preg_match('/[ก-๙]/i', $call->getFName())? 'th': 'en';
$fname_url = "http://translate.google.com/translate_tts?tl={$lang}&ie=UTF-8&q=".urlencode(trim($call->getFName()));

$lang = preg_match('/[ก-๙]/i', $call->getLName())? 'th': 'en';
$lname_url = "http://translate.google.com/translate_tts?tl={$lang}&ie=UTF-8&q=".urlencode(trim($call->getLName()));
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
<audio class="sound-player" id="prefix1" controls autoplay style="display:none;">
  <source src="<?php echo $prefix1->getPath();?>" type="audio/wav">
</audio>

<audio class="sound-player" id="firstname" controls style="display:none;">
  <source src="<?php echo $firstname_path; ?>" type="audio/mpeg">
</audio>

<audio class="sound-player" id="lastname" controls style="display:none;">
  <source src="<?php echo $lastname_path; ?>" type="audio/mpeg">
</audio>

<audio class="sound-player" id="prefix2" controls style="display:none;">
    <source src="<?php echo $prefix2->getPath()?>" type="audio/mpeg">
</audio>

<audio class="sound-player" id="prefix3" controls style="display:none;">
    <source src="<?php echo $prefix3->getPath()?>" type="audio/mpeg">
</audio>

<style>
    .boxshadow {
        border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 10px 10px 10px 10px;
        -webkit-border-radius: 10px 10px 10px 10px;
        border: 0px solid #000000;
        -moz-box-shadow: 0 0 10px 1px #333;
        -webkit-box-shadow: 0 0 10px 1px #333;
        box-shadow: 0 0 10px 1px #333;
        margin-bottom: 16px;
    }
    body, html {
        width: 100%;
        height: 100%;
    }

    body {
        background: url("<?php echo $bgUrl;?>");
    }
</style>
<div class="row">
    <h1 class="text-center" style="text-shadow: 4px 4px 2px rgba(150, 150, 150, 1);font-size: 90px;line-height: 80px;padding-bottom: 46px;"><i class="icon-volume-up"></i> <?php echo $prefix1->getName();?></h1>
</div>
<div class='row' >
    <div class='col-md-6'>
        <div class="box-content box-double-padding text-center">
            <div style="padding-top: 50px;">
                <img data-src="holder.js/140x140" class="img-thumbnail hn-image" alt="140x140" src="<?php echo $hnUrl;?>" style="width: 240px; height: 240px;">
                <h1 style="text-shadow: 4px 4px 2px rgba(150, 150, 150, 1);font-size: 70px; line-height: 80px;"><?php echo $call->getFName()." ".$call->getLname();?></h1>
            </div>
        </div>
    </div>
    <div class='col-md-6'>
        <div class="box-content box-double-padding text-center">
            <div style="padding-top: 50px;">
                <img class="img-thumbnail" alt="140x140" src="<?php echo $prefix2->getPicturePath();?>" style="width: 240px; height: 240px;">
                <h1 style="text-shadow: 4px 4px 2px rgba(150, 150, 150, 1);font-size: 70px; line-height: 80px;"><?php echo $prefix2->getRoomName();?></h1>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        var prefix1 = document.getElementById('prefix1');
        var fname = document.getElementById('firstname');
        var lname = document.getElementById('lastname');
        var prefix2 = document.getElementById('prefix2');
        var prefix3 = document.getElementById('prefix3');

        prefix1.addEventListener('ended', function(){
            this.currentTime = 0;
            this.pause();
            fname.play();
        }, false);
        prefix1.addEventListener('error', function(){
            this.currentTime = 0;
            this.pause();
            fname.play();
        }, false);


        fname.addEventListener('ended', function(){
            this.currentTime = 0;
            this.pause();
            lname.play();
        }, false);
        fname.addEventListener('error', function(){
            this.currentTime = 0;
            this.pause();
            lname.play();
        }, false);


        lname.addEventListener('ended', function failed(e){
            this.currentTime = 0;
            this.pause();
            prefix2.play();
        }, true);
        lname.addEventListener('error', function failed(e){
            this.currentTime = 0;
            this.pause();
            prefix2.play();
        }, true);

        prefix2.addEventListener('ended', function(){
            this.currentTime = 0;
            this.pause();
            prefix3.play();
        }, false);

        prefix2.addEventListener('error', function(){
            this.currentTime = 0;
            this.pause();
            prefix3.play();
        }, false);

        prefix3.addEventListener('ended', function failed(e){
            setTimeout(function(){ window.close(); }, 3000);
        }, true);
        prefix3.addEventListener('error', function failed(e){
            setTimeout(function(){ window.close(); }, 3000);
        }, true);

        var nImg = $('.hn-image')[0];

        nImg.onerror = function() {
            nImg.src = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjcwIiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE0MHgxNDA8L3RleHQ+PC9zdmc+";
        }
    });


</script>
<script type="text/javascript">
    setTimeout(function(){ window.close(); }, 15000);
</script>
</body>
</html>