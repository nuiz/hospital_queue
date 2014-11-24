<?php
/**
 * Created by PhpStorm.
 * User: Papangping
 * Date: 10/26/14
 * Time: 10:22 PM
 */

$splctyList = isset($_GET['spclty']) || !empty($_GET['spclty'])? explode(",", $_GET['spclty']): false;

$queEM = \Main\DB::queEM();

$qb = $queEM->getRepository('Main\Entity\Que\Spclty')->createQueryBuilder('a');
$q = $qb->getQuery();

/** @var \Main\Entity\Que\Spclty[] $spcltys */
$spcltys = $q->getResult();


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
.boxtree {
    display: inline-block;
    width: 220px;
    margin-right: 20px;
}
.yellow-background {
    background: #FDF9EF;
}
.red-background {
    background: #FFD2D3  !important;
}
</style>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-volume-down" aria-hidden="true"></span> Sound Setting</h3>
    </div>
    <div class="panel-body">
        <div class="boxtree">
        <h4>Prefix 1</h4> <select id="prefix1_path" class="selecter_2">
            <?php foreach($pfxs1 as $key=> $value){
                $id = $value->getId();
                $name = $value->getName();
                echo <<<HTML
        <option value="{$id}">{$name}</option>
HTML;

            }
            ?>

        </select>
        </div>
        <div class="boxtree">
            <h4>Prefix 2</h4> <select id="prefix2_path" class="selecter_2">
            <?php foreach($pfxs2 as $key=> $value){
                $id = $value->getId();
                $name = $value->getName();
                echo <<<HTML
        <option value="{$id}">{$name}</option>
HTML;

            }
            ?>
        </select>
        </div>
        <div class="boxtree">
            <h4>Prefix 3</h4> <select id="prefix3_path" class="selecter_2">
            <?php foreach($pfxs3 as $key=> $value){
                $id = $value->getId();
                $name = $value->getName();
                echo <<<HTML
        <option value="{$id}">{$name}</option>
HTML;

            }
            ?>
        </select>
        </div>

    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading" id="depDivBtu">
        <h3 class="panel-title"><span class="glyphicon glyphicon-th" aria-hidden="true"> </span> Department Setting</h3>
    </div>
    <div class="panel-body">

<div id="depDiv" style="display:none;">
        <form class="spclty-form">
            <?php
            foreach($spcltys as $key=> $item){
                $number = $item->getSpclty();
                $name = $item->getName();
                $checked = $splctyList && in_array($item->getSpclty(), $splctyList)? "checked": "";
                $color = $splctyList && in_array($item->getSpclty(), $splctyList)? "color: #3498DB;": "color: #6C7A89";
                echo <<<HTML
    <label style="display: inline-block; width: 200px; {$color}" ><input class="spclty-checkbox" type="checkbox" value="{$number}" {$checked}> {$name} </label>
HTML;
            } ?>
            <input type="hidden" name="spclty" value="<?php echo implode(',', (array)$splctyList);?>">
            <hr>
            <button class="spclty-select-all btn btn-info" type="button">Select all</button> <button class="spclty-unselect-all btn btn-info" type="button">Unselect all</button> <button class="btn btn-primary" type="submit">Display select</button>

        </form>
</div>
    </div>

</div>

<script type="text/javascript">
$(function(){

	$('#depDivBtu').click(function(){

	if ($("#depDiv").css("display")== "none") {
	
$("#depDiv").show();
         } else {
$("#depDiv").hide();
			
	}
});
    var form = $('.spclty-form');
    $('.spclty-checkbox').change(function(e){
        var list = [];
        $('.spclty-checkbox:checked').each(function(key, item){
            list.push($(item).val());
        });
        $('input[name="spclty"]', form).val(list.join(','));
    });

    $('.spclty-select-all').click(function(e){
        e.preventDefault();
        $('.spclty-checkbox').prop('checked', true);
        $('.spclty-checkbox').change();
    });

    $('.spclty-unselect-all').click(function(e){
        e.preventDefault();
        $('.spclty-checkbox').prop('checked', false);
        $('.spclty-checkbox').change();
    });
});
</script>
<div class="bs-callout bs-callout-info bg-white">
    <button type="button" class="btn btn-default open-show">เรียกหน้าต่างแสดงคิวแบบเล็ก</button>
</div>

<div class="bs-callout bs-callout-warning bg-white">
    <form class="form-inline scan-form" role="form">
        <div class="form-group">
            <input type="text" class="form-control input-scan" placeholder="Human ID">
        </div>
        <button type="submit" class="btn btn-default">Scan</button>
        <div style="padding-top: 10px;">
            <span class="label label-primary">F9 : Focus</span>
            <span class="label label-info">F6 : Call</span>
<!--            <span class="label label-warning">F7 : Hide</span>-->
<!--            <span class="label label-danger">F8 : Skip</span>-->
        </div>
    </form>
</div>
<div class="row scan-user-block bs-callout bs-callout-warning bg-white" style="display: none;">
    <div class="col-md-4">
        <img data-src="holder.js/140x140" class="img-thumbnail" alt="140x140" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjcwIiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE0MHgxNDA8L3RleHQ+PC9zdmc+" style="width: 140px; height: 140px;">

    </div>
    <div class="col-md-8">
        <h4 class="scan-hn"></h4>
        <span class="scan-fname"></span>
        <span class="scan-lname"></span>
        <hr>
        <div>
            <button class="btn scan-call-btn btn-info">Call</button>
<!--            <button class="btn scan-hide-btn btn-warning">Hide</button>-->
<!--            <button class="btn scan-skip-btn btn-danger">Skip</button>-->
        </div>
    </div>
</div>
<script type="text/javascript">
$(function(){
//    $('.scan-hide-btn').click(function(e){
//        $(this).prop('disabled', true);
//        if(!$('.hide-btn', trScan).prop('disabled')){
//            $('.hide-btn', trScan).click();
//        }
//    });
//    $('.scan-skip-btn').click(function(e){
//        $(this).prop('disabled', true);
//        if(!$('.skip-btn', trScan).prop('disabled')){
//            $('.skip-btn', trScan).click();
//        }
//    });

    var block = $('.scan-user-block');
    var input = $('.input-scan');
    var form = $('.scan-form');
    var callBtn = $('.scan-call-btn');

    var searchItem;
    var setting;

    form.submit(function(e){
        e.preventDefault();

        $('input, button', form).prop('disabled', true);

        $.post('api.php?ctl=QueCTL&method=searchByHn', { hn: input.val() }, function(data){
            $('input, button', form).prop('disabled', false);

            console.log(data);

            if(typeof data.error != 'undefined'){
                alert(data.message);
                return;
            }

            input.val('');
            block.show();
            searchItem = data.item;
            setting = data.setting;

            $('.scan-hn').text(searchItem.hn);
            $('.scan-fname').text(searchItem.fname);
            $('.scan-lname').text(searchItem.lname);

            if(setting.call_after_scan){
                callBtn.click();
            }


        }, 'json');

//        var item = trScan.data('entity');
    });

    callBtn.click(function(e){
        $(that).prop('disabled', true);
        var that = this;
        e.preventDefault();

        var send = {
//            spclty: item.spclty,
            fname: searchItem.fname,
            lname: searchItem.lname,
            prefix1_id: $('#prefix1_path').val(),
            prefix2_id: $('#prefix2_path').val(),
            prefix3_id: $('#prefix3_path').val(),
            hn: searchItem.hn
        };
        $( that ).prop("disabled", true);
        $.post("api.php?ctl=CallCTL&method=call", send, function(data){
            $( that ).prop("disabled", false);
            console.log(data);
        }, 'json');
    });

    $(window).keydown(function(e) {
        if (e.keyCode == 120) {
            $(".input-scan").focus();
            return;
        }
        if (e.keyCode===117) {
            callBtn.click();
        }
    });
});
</script>

<div class="bs-callout bs-callout-danger bg-white">
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
        <td><form class="note-form"><input type="text" class="note-input"></form></td>
        <td>
            <button class="btn call-btn btn-info">Call</button>
            <button class="btn hide-btn btn-warning">Hide</button>
            <button class="btn skip-btn btn-danger">Skip</button>
            <button class="btn drug-btn btn-info">สั่งยา</button>
        </td>
    </tr>
</script>
<script type="text/javascript">
$(function(){
    $(".selecter_2").selecter();

    var spcltyList = <?php echo json_encode($splctyList);?>;
    function isSpcltyAllow(spclty){
        if(!spcltyList)
            return false;
        if(jQuery.inArray( spclty, spcltyList ) != -1)
            return true;

        return false;
    }

    $('.open-show').click(function(){
        var url = 'show.php';
        if(spcltyList){
            url += "?spclty=" + spcltyList.join(',');
        }
        window.open(url, '', 'width=400, height='+screen.height);
    });

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

        var noteInput = $('.note-input', el);
        noteInput.val(item.note);

        if(item.note.length > 0){
            el.addClass("red-background");
        }

        $(el).attr("hn", item.hn);
        $(el).attr("vn", item.vn);
        $(el).attr("id", item.id);
        $(el).attr("vsttime", item.vsttime);

        var intervalYellow = setInterval(function(){
            var ts = Date.now()-3000;
            ts = parseInt(ts/1000);
            if($(el).attr('vsttime') < ts){
                $(el).addClass("yellow-background");
                clearInterval(intervalYellow);
            }
        }, 1000);

        $('.note-form', el).submit(function(e){
            e.preventDefault();
            noteInput.prop("disabled", true);
            $.post("api.php?ctl=QueCTL&method=editNote", {id: item.id, note: noteInput.val().trim() }, function(data){
                noteInput.prop("disabled", false);
                console.log(data);
            }, 'json');
        });

        $('.skip-btn', el).click(function(e){
            var that = this;
            e.preventDefault();
            $( that ).prop("disabled", true);
            $.post("api.php?ctl=QueCTL&method=skip", {id: item.id}, function(data){
                $( that ).prop("disabled", false);
                console.log(data);
            }, 'json');
        });

        $('.call-btn', el).click(function(e){
            var that = this;
            e.preventDefault();

            var send = {
                spclty: item.spclty,
                fname: item.fname,
                lname: item.lname,
                prefix1_id: $('#prefix1_path').val(),
                prefix2_id: $('#prefix2_path').val(),
                prefix3_id: $('#prefix3_path').val(),
                hn: item.hn
            };
            $( that ).prop("disabled", true);
            $.post("api.php?ctl=CallCTL&method=call", send, function(data){
                $( that ).prop("disabled", false);

                // trigger scan form
                if($('.scan-hn').text() == item.hn){
                    $('.scan-call-btn').prop('disabled', false);
                }

                console.log(data);
            }, 'json');
        });

        $('.hide-btn', el).text(item.is_hide? "show": "hide").attr("is_hide", item.is_hide? "1": "0").click(function(e){
            var that = this;
            e.preventDefault();
            $( that ).prop("disabled", true);

            var send = {id: item.id};
            if($(that).attr("is_hide")==0){
                send.is_hide = 1;
            }
            else {
                send.is_hide = 0;
            }
            $.post("api.php?ctl=QueCTL&method=hide", send, function(data){
                $( that ).prop("disabled", false);
                console.log(data);
            }, 'json');
        });

        $('.drug-btn', el).click(function(e){
            e.preventDefault();
            var that = this;
            $( that ).prop("disabled", true);
            $.post("api.php?ctl=QueCTL&method=syncDrug", { id: item.id }, function(data){
                $( that ).prop("disabled", false);
                console.log(data);
            }, 'json');
        });

        $(el).data('entity', item);

        return el;
    };

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
                        if(!isSpcltyAllow(action.data[i].spclty)) continue;

                        if(action.data[i].is_hide==true){
                            $('.hide-queue-list').append(createRow(action.data[i]));
                        }
                        else {
                            $('.show-queue-list').append(createRow(action.data[i]));
                        }
                    }
                }
            }

            if(typeof json.publish != 'undefined'){
                var pubName = json.publish.name;
                var data = json.publish.data;


                if(pubName=="add"){
                    if(!isSpcltyAllow(data.spclty)) return;

                    var table = $('.show-queue-list');
                    if($('.queTr:first', table).attr('vsttime') > data.vsttime){
                        table.prepend(tr);
                    }
                    else if($('.queTr:last', table).attr('vsttime') < data.vsttime){
                        table.append(tr);
                    }
                    else if($('.queTr', table).size() > 0) {
                        $('.queTr', table).each(function(idex, item){
                            if($(item).attr('vsttime') < data.vsttime && $(item).next().attr('vsttime') > data.vsttime){
                                $(item).after(tr);
                                return false;
                            }
                        });
                    }
                    else {
                        table.append(tr);
                    }
                }
                else if(pubName=="skip"){
                    if(!isSpcltyAllow(data.spclty)) return;
                    $('.queTr[id="'+data.id+'"]').remove();

                    // trigger scan form
                    if($('.scan-hn').text() == data.hn){
                        $('.scan-user-block').hide();
                    }
                }
                else if(pubName=="hide"){
                    if(!isSpcltyAllow(data.spclty)) return;
                    var tr = $('.queTr[id="'+data.id+'"]');
                    var table;
                    if(data.is_hide==true){
                        $('.hide-btn', tr).text('show').attr("is_hide", 1);
                        table = $('.hide-queue-list').append(tr);
                    }
                    else {
                        $('.hide-btn', tr).text('hide').attr("is_hide", 0);
                        table = $('.show-queue-list').append(tr);
                    }

                    if($('.queTr:first', table).attr('vsttime') > data.vsttime){
                        table.prepend(tr);
                    }
                    else if($('.queTr:last', table).attr('vsttime') < data.vsttime){
                        table.append(tr);
                    }
                    else if($('.queTr', table).size() > 0) {
                        $('.queTr', table).each(function(idex, item){
                            if($(item).attr('vsttime') < data.vsttime && $(item).next().attr('vsttime') > data.vsttime){
                                $(item).after(tr);
                                return false;
                            }
                        });
                    }
                    else {
                        table.append(tr);
                    }

                    tr.data('entity', data);

                    // trigger scan form
                    if($('.scan-hn').text() == data.hn){
                        $('.scan-hide-btn').text($('.hide-btn', tr).text()).prop('disabled', false);
                    }
                }
                else if(pubName=="clear"){
//                    $('.show-queue-list tr').remove();
//                    $('.hide-queue-list tr').remove();
                    conn.close();
                }
                else if(pubName=="editNote") {
                    var tr = $('.queTr[id="'+data.id+'"]');
                    $('.note-input', tr).val(data.note);
                    tr.data('entity', data);
                    if(data.note.length > 0){
                        tr.addClass("red-background");
                    }
                    else {
                        tr.removeClass("red-background");
                    }
                }
            }
        };

        conn.onerror = function(){
            setTimeout(function(){ conn.close(); }, 3000);
        };

        conn.onclose = function(){
            $('.show-queue-list tr').remove();
            $('.hide-queue-list tr').remove();
            setTimeout(function(){ skConnect(); }, 3000);
        };

        conn.onopen = function(){
            $('.show-queue-list tr').remove();
            $('.hide-queue-list tr').remove();
            conn.send(JSON.stringify({ action: {name: 'QueCTL/gets'}, subscribe: ["add", "skip", "hide", "clear", "editNote"] }));
        }
    };

    skConnect();

    $('.tab-btn').click(function(e){
        var href = $(this).attr('href');
        $('.tab').hide();
        $(href).show();
        $('.tab-btn').closest('li').removeClass('active');
        $(this).closest('li').addClass('active');
    });
    $('.tab-btn').first().click();

    $('.scan-form').submit(function(e){
        e.preventDefault();
    });
});

</script>
