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

    <link rel="stylesheet" href="css/main.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="js/jquery.isloading.min.js"></script>
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

</style>
<div class="row-fluid dep-ctx">
    <div class="span12 box">
        <div class="box-header red-background" style="font-size: 26px;
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
    <table class="table show-queue-list">

    </table>
</div>
<script type="text/template" id="que-template">
    <tr class="queTr que">
        <td class="col-md-4 hn"></td>
        <td class="col-md-6 name"></td>
        <td class="col-md-2 vsttime"></td>
    </tr>
</script>
<script type="text/javascript">
$(function(){
    var spcltyList = <?php echo json_encode($splctyList);?>;
    function isSpcltyAllow(spclty){
        if(!spcltyList)
            return true;
        if(jQuery.inArray( spclty, spcltyList ) != -1)
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

        $('.hn', el).text(item.hn);
        $('.name', el).text(item.fname + " " + item.lname);
        $('.vsttime', el).text(vsttime);

        $(el).attr("vn", item.vn);
        $(el).attr("id", item.id);

        if(item.is_hide==true){
            $(el).hide();
        }
        else {
            $(el).show();
        }

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
            conn.send(JSON.stringify({ action: {name: 'QueCTL/gets'}, subscribe: ["add", "skip", "call", "hide", "clear"] }));
        }
    };

    skConnect();
});
</script>
</body>
</html>