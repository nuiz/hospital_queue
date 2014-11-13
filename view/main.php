<?php
/**
 * Created by PhpStorm.
 * User: Papangping
 * Date: 10/26/14
 * Time: 10:22 PM
 */
$queEM = \Main\DB::queEM();

$qb = $queEM->getRepository('Main\Entity\Que\SoundPrefix1')->createQueryBuilder('a');
$qb->orderBy('a.created_at');
$q = $qb->getQuery();
$pfxs1 = $q->getResult();

$qb = $queEM->getRepository('Main\Entity\Que\SoundPrefix2')->createQueryBuilder('a');
$qb->orderBy('a.created_at');
$q = $qb->getQuery();
$pfxs2 = $q->getResult();

$qb = $queEM->getRepository('Main\Entity\Que\SoundPrefix3')->createQueryBuilder('a');
$qb->orderBy('a.created_at');
$q = $qb->getQuery();
$pfxs3 = $q->getResult();
?>
<style type="text/css">
.tab {
    display: none;
}
</style>
<div>
    Prefix 1 <select id="prefix1_path">
        <?php foreach($pfxs1 as $key=> $value){
            $path = $value->getPath();
            $name = $value->getName();
            echo <<<HTML
        <option value="{$path}">{$name}</option>
HTML;

        }
        ?>
    </select>
    Prefix 2 <select id="prefix2_path">
        <?php foreach($pfxs2 as $key=> $value){
            $path = $value->getPath();
            $name = $value->getName();
            echo <<<HTML
        <option value="{$path}">{$name}</option>
HTML;

        }
        ?>
    </select>
    Prefix 3 <select id="prefix3_path">
        <?php foreach($pfxs3 as $key=> $value){
            $path = $value->getPath();
            $name = $value->getName();
            echo <<<HTML
        <option value="{$path}">{$name}</option>
HTML;

        }
        ?>
    </select>
</div>
<hr>
<button type="button" class="btn" onclick="window.open('show.php', '', 'width=400, height='+screen.height);">เรียกหน้าต่างแสดงคิวแบบเล็ก</button>
<hr>
<div>
    <form class="form-inline scan-form" role="form">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Human ID">
        </div>
        <button type="submit" class="btn btn-default">Scan</button>
    </form>
</div>
<hr>
<div>
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1" class="tab-btn">Show</a></li>
        <li><a href="#tab2" class="tab-btn">Hide</a></li>
    </ul>
    <div id="tab1" class="tab">
        <table class='table table-bordered'>
            <thead>
            <tr>
                <th>
                    HN ID
                </th>
                <th>
                    ชื่อ นามสกุล
                </th>
                <th>
                    เวลา
                </th>
                <th>
                </th>
            </tr>
            </thead>
            <tbody class="show-queue-list">
            </tbody>
        </table>
    </div>
    <div id="tab2" class="tab">
        <table class='table table-bordered'>
            <thead>
            <tr>
                <th>
                    HN ID
                </th>
                <th>
                    ชื่อ นามสกุล
                </th>
                <th>
                    เวลา
                </th>
                <th>
                </th>
            </tr>
            </thead>
            <tbody class="hide-queue-list">

            </tbody>
        </table>
    </div>
</div>
<script type="text/template" id="queTr-template">
    <tr class="queTr">
        <td class="hn"></td>
        <td class="name"></td>
        <td class="vsttime"></td>
        <td>
            <button class="call-btn">Call</button>
            <button class="hide-btn">Hide</button>
            <button class="skip-btn">Skip</button>
        </td>
    </tr>
</script>
<script type="text/javascript">
$(function(){
    function createRow(item){
        var html = $('#queTr-template').text();
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

        $('.skip-btn', el).click(function(e){
            e.preventDefault();
            $.post("api.php?ctl=QueCTL&method=skip", {id: item.id}, function(data){
                console.log(data);
            }, 'json');
        });

        $('.call-btn', el).click(function(e){
            e.preventDefault();
            var send = {
                fname: item.fname,
                lname: item.lname,
                prefix1_path: $('#prefix1_path').val(),
                prefix2_path: $('#prefix2_path').val(),
                prefix3_path: $('#prefix3_path').val()
            };
            $.post("api.php?ctl=CallCTL&method=call", send, function(data){
                console.log(data);
            }, 'json');
        });

        return el;
    }

    var conn;
    function skConnect(){
        if(conn instanceof WebSocket){
            conn.close();
        }
        conn = new WebSocket(<?php echo json_encode(Main\Helper\GeneralHelper::url_socket());?>);

        conn.onmessage = function(e){
            var json = JSON.parse(e.data);
            var i;

            console.log(json);

            if(typeof json.action != 'undefined'){
                var action = json.action;
                if(action.name == 'QueCTL/gets'){
                    for(i in action.data){
                        $('.show-queue-list').append(createRow(action.data[i]));
                    }
                }
            }

            if(typeof json.publish != 'undefined'){
                var pubName = json.publish.name;
                var data = json.publish.data;

                if(pubName=="add"){
                    $('.show-queue-list').append(createRow(data));
                }
                else if(pubName=="skip"){
                    $('.queTr[id="'+data.id+'"]').remove();
                }
            }
        };

        conn.onerror = function(){
            setTimeout(function(){ skConnect(); }, 3000);
        };

        conn.onopen = function(){
            $('.show-queue-list tr').remove();
            $('.hide-queue-list tr').remove();
            conn.send(JSON.stringify({ action: {name: 'QueCTL/gets'}, subscribe: ["add", "skip"] }));
        }
    };

    skConnect();

    $('.tab-btn').click(function(e){
        var href = $(this).attr('href');
        $('.tab').hide();
        $(href).show();
    });
    $('.tab-btn').first().click();

    $('.scan-form').submit(function(e){
        e.preventDefault();
    });
});
</script>