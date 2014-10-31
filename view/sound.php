<?php
/**
 * Created by PhpStorm.
 * User: Papangping
 * Date: 10/26/14
 * Time: 10:22 PM
 */
?>
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add sound</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="add-form" method="post">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter name">
                    </div>
                    <input type="hidden" name="prefix" value="1">
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div>
            <button class="add-sound pull-right add-btn" prefix="1">Add</button>
            <h3>Prefix 1</h3>
        </div>
        <table class='table table-bordered'>
            <thead>
            <tr>
                <th>
                    Sound
                </th>
                <th>
                </th>
            </tr>
            </thead>
            <tbody id="tbody-prefix1">
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <div>
            <button class="add-sound pull-right">Add</button>
            <h3>Prefix 2</h3>
        </div>
        <table class='table table-bordered'>
            <thead>
            <tr>
                <th>
                    Sound
                </th>
                <th>
                </th>
            </tr>
            </thead>
            <tbody class="">
            <tr>
                <td>ที่ห้อง</td>
                <td>
                    <button>Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <div>
            <button class="add-sound pull-right">Add</button>
            <h3>Prefix 3</h3>
        </div>
        <table class='table table-bordered'>
            <thead>
            <tr>
                <th>
                    Sound
                </th>
                <th>
                </th>
            </tr>
            </thead>
            <tbody class="">
            <tr>
                <td>ด้วยค่ะ</td>
                <td>
                    <button>Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(function(){
    // Action on Click
    $.isLoading({ text: "Loading" });

    function createRow(item, prefix){
        var html = $('#template-row').html();
        html = html.replace('{{name}}', item.name);
        html = html.replace('{{deleteHref}}', 'api.php?ctl=SoundCTL&method=remove&prefix='+prefix+'&id='+item.id);

        var el = $(html);
        $('.remove-btn', el).click(function(e){
            e.preventDefault();
            $.isLoading({ text: "Loading" });
            $.post($(this).attr('href'), {}, function(data){
                $.isLoading( "hide" );
                if(typeof data.error != "undefined"){
                    console.log(data);
                    return;
                }
                el.remove();
            }, 'json');
        });
        return el;
    };

    var tbodyPrefix1 = $('#tbody-prefix1');

    $.post("api.php?ctl=SoundCTL&method=getsAllPrefix", {}, function(data){
        $.isLoading( "hide" );
        var i;
        var row;
        var item;
        for(i in data.prefix1){
            item = data.prefix1[i];
            row = createRow(item, 1);
            tbodyPrefix1.append(row);
        }
    }, 'json');

    $('.add-btn').click(function(e){
        e.preventDefault();
        var tbody = tbodyPrefix1;
        $('#addModal input[name="prefix"]').val("1");
        $('#addModal').modal();
    });

    $('#add-form').submit(function(e){
        e.preventDefault();
        $.post("api.php?ctl=SoundCTL&method=add", $(this).serialize(), function(data){
            if(typeof data.error != "undefined"){
                console.log(data);
                return;
            }
            window.location.reload(true);
        }, 'json');
    });
});
</script>
<script type="text/template" id="template-row">
    <tr>
        <td>{{name}}</td>
        <td>
            <button class="remove-btn" href="{{deleteHref}}">Delete</button>
        </td>
    </tr>
</script>