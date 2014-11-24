<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 13/11/2557
 * Time: 10:18 น.
 */
require_once 'bootstrap.php';

$splctyList = isset($_GET['spclty'])? explode(",", $_GET['spclty']): false;

$queEM = \Main\DB::queEM();

$qb = $queEM->getRepository('Main\Entity\Que\Spclty')->createQueryBuilder('a');
$q = $qb->getQuery();

/** @var \Main\Entity\Que\Spclty[] $spcltys */
$spcltys = $q->getResult();
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
<body>
<style type="text/css">
    .yellow-bg {
        background-color: #FEFCCB;
        border-bottom-color: #E5DB55;
        border-bottom-width: 3px;
        border-bottom-style: solid;
    }
    .red-background-remark {
        background: #FFD2D3;
        border-bottom-color: #DF8F90;
        border-bottom-width: 3px;
        border-bottom-style: solid;
    }
    .queTr {
        padding: 10px 10px;
        border-bottom: 1px solid gray;
    }
    .yellow-background {
        background: #FDF9EF;
    }
    .red-background {
        background: #FFD2D3 !important;
    }
    .note-input {
        color: #999999;
    }
    .midHeader {
border-bottom: 4px solid #8CC152;
    }
    .midHeader2 {
        display:inline-block;
        font-size:24px;
    }
</style>
<div class="dep-ctx">
    <div class="box">
        <div class="box-header" style="font-size: 26px;
    font-weight: 200;
    line-height: 30px;
    padding: 10px 15px;
    height: 50px;
    background-color: #A0D468;
    border-bottom: 4px solid #8CC152;
    ">
            <div class="text-left title">
                <i class="glyphicon glyphicon-list-alt"></i> รายชื่อคิว <span id="time" class="pull-right"></span>
            </div>
        </div>
    </div>
    <div class="midHeader">
        <div class="midHeader2" style="padding-right:20px;">ลำดับ</div>
        <div class="midHeader2" style="padding-left:26px;">ชื่อ</div>
        <div class="midHeader2" style="padding-left:100px;">ปริมาณงาน/ยา</div>
    </div>
    <div class="show-queue-list">

    </div>
</div>
<script type="text/template" id="que-template">
    <div class="row queTr que">
        <div class="col-md-2 col-sm-2 col-xs-2 hn" style="font-size:30px;"></div>
        <div class="col-md-10 col-sm-10 col-xs-8" style="font-size:30px;">
            <div class="name"></div>
            <small class="note-input"></small>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2 drug" style="font-size:30px;"></div>
    </div>
</script>
<script type="text/javascript">
$(function(){
    var spcltyList = <?php echo json_encode($splctyList);?>;
    function isSpcltyAllow(spclty){
        if(!spcltyList)
            return true;
        if(jQuery.inArray( spclty, spcltyList ) != -1)
            return true;
        if(spclty==null)
            return true;

        return false;
    }

    function date() {
        var now = new Date(),
            now = now.getHours()+':'+now.getMinutes()+':'+now.getSeconds();
        $('#time').html(now);
    }
    date();
    setInterval(date, 1000);

    var ctx = $('.dep-ctx');

    var callStack = {
        stack: [],
        calling: false,
        push: function(data){
            callStack.stack.push(data);
        },
        call: function(){
            if(callStack.stack.length == 0){
                callStack.calling = false;
                return;
            }
            callStack.calling = true;

            var data = callStack.stack.shift();

            var params = [
                'height='+screen.height,
                'width='+screen.width,
                'left=0',
                'top=0'
                //'fullscreen=yes' // only works in IE, but here for completeness
            ].join(',');

            var href = 'call.php?id='+data.id;
            var w = window.open(href, '', params);

            var interval = window.setInterval(function() {
                try {
                    if (w == null || w.closed) {
                        window.clearInterval(interval);
                        callStack.call();
                    }
                }
                catch (e) {
                    alert('error');
                }
            }, 100);
        },
        startCall: function(){
            if(callStack.calling){
                return;
            }
            callStack.call();
        }
    };

    function createRow(item){
        var html = $('#que-template').text();
        var el = $(html);

        var date = new Date(item.vsttime*1000);
        var hours = date.getHours();
        var minutes = "0" + date.getMinutes();

        var vsttime = hours + ':' + minutes.substr(minutes.length-2);

//        $('.hn', el).text(item.hn);
        $('.name', el).text(item.fname + " " + item.lname);
        $('.vsttime', el).text(vsttime);

        $('.note-input', el).text(item.note);
        if(item.note.length > 0){
            el.addClass("red-background");
        }
        if(item.drug != null){
            $('.drug', el).text(item.drug);
        }

        $(el).attr("hn", item.hn);
        $(el).attr("vn", item.vn);
        $(el).attr("id", item.id);
        $(el).attr("vsttime", item.vsttime);


        if(item.is_hide==true){
            $(el).hide();
        }
        else {
            $(el).show();
        }

        var intervalYellow = setInterval(function(){
            var ts = Date.now()-3000;
            ts = parseInt(ts/1000);
            if($(el).attr('vsttime') < ts){
                $(el).addClass("yellow-background");
                clearInterval(intervalYellow);
            }
        }, 1000);

        return el;
    }

    var conn;
    function skConnect(){
        if(conn instanceof WebSocket){
            conn.close();
        }
        conn = new WebSocket(<?php echo json_encode(\Main\Helper\GeneralHelper::url_socket());?>);

        conn.onmessage = function(e){
            var json = JSON.parse(e.data);
            var event = json.event;
            var data = json.data;
            console.log(json);

            if(typeof json.action != 'undefined'){
                var action = json.action;
                if(action.name == 'QueCTL/gets'){
                    for(i in action.data){
                        if(!isSpcltyAllow(action.data[i].spclty)) continue;
                        $('.show-queue-list').append(createRow(action.data[i]));
                    }

                    $('.queTr:visible').each(function(index, el){
                        $('.hn', el).text(index + 1);
                    });
                }
            }

            if(typeof json.publish != 'undefined'){
                var pubName = json.publish.name;
                var data = json.publish.data;

                if(pubName=="add"){
                    if(!isSpcltyAllow(data.spclty)) return;
                    $('.show-queue-list').append(createRow(data));
                }
                else if(pubName=="skip"){
                    if(!isSpcltyAllow(data.spclty)) return;
                    $('.queTr[id="'+data.id+'"]').remove();
                }
                else if(pubName=="call"){
                    if(!isSpcltyAllow(data.spclty)) return;
                    callStack.push(data);
                    callStack.startCall();
                }
                else if(pubName=="hide"){
                    if(!isSpcltyAllow(data.spclty)) return;
                    var tr = $('.queTr[id="'+data.id+'"]');
                    if(data.is_hide==true){
                        tr.hide();
                    }
                    else {
                        tr.show();
                    }
                }
                else if(pubName=="clear"){
//                    $('.show-queue-list tr').remove();
                    conn.close();
                }
                else if(pubName=="editNote") {
                    var tr = $('.queTr[id="'+data.id+'"]');
                    $('.note-input', tr).text(data.note);
                    tr.data('entity', data);
                    if(data.note.length > 0){
                        tr.addClass("red-background");
                    }
                    else {
                        tr.removeClass("red-background");
                    }
                }
                else if(pubName=="drug"){
                    var tr = $('.queTr[id="'+data.id+'"]');

                    if(isSpcltyAllow("21")){
                        if(tr.size() == 0){
                            tr = createRow(data);
                            $('.show-queue-list').append(tr)
                        }
                        $('.drug', tr).text(data.drug);;
                    }
                    else {
                        tr.remove();
                    }
                }

                $('.queTr:visible').each(function(index, el){
                    $('.hn', el).text(index + 1);
                });
            }
        };

        conn.onerror = function(){
            setTimeout(function(){ conn.close(); }, 3000);
        };

        conn.onclose = function(){
            $('.show-queue-list tr').remove();
            setTimeout(function(){ skConnect(); }, 3000);
        };

        conn.onopen = function(){
            $('.show-queue-list tr').remove();
            conn.send(JSON.stringify({ action: {name: 'QueCTL/gets'}, subscribe: ["add", "skip", "call", "hide", "clear", "editNote", "drug"] }));
        }
    };

    skConnect();
});
</script>
</body>
</html>
