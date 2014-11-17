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
                        <input type="text" class="form-control name-val" name="name" placeholder="Enter name">
                    </div>
                    <div class="form-group show-prefix2" style="display: none;">
                        <label>Picture</label>
                        <input type="file" class="form-control picture-input" name="picture">
                    </div>
                    <div class="form-group show-prefix2" style="display: none;">
                        <label>Room name</label>
                        <input type="text" class="form-control room_name-input" name="room_name">
                    </div>
                    <input type="hidden" name="prefix" id="prefix-val" value="1">
                    <button type="submit" class="btn btn-default submit-btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row" style="background-color: #ffffff;">
    <div class="col-md-3">
        <div>
            <button class="add-sound pull-right add-btn btn-primary" prefix="1">Add</button>
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
    <div class="col-md-6">
        <div>
            <button class="add-sound pull-right add-btn btn-primary" prefix="2">Add</button>
            <h3>Prefix 2</h3>
        </div>
        <table class='table table-bordered'>
            <thead>
            <tr>
                <th>
                    Sound
                </th>
                <th>
                    Picture
                </th>
                <th>
                    Room name
                </th>
                <th>
                </th>
            </tr>
            </thead>
            <tbody id="tbody-prefix2">
            </tbody>
        </table>
    </div>
    <div class="col-md-3">
        <div>
            <button class="add-sound pull-right add-btn btn-primary" prefix="3">Add</button>
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
            <tbody id="tbody-prefix3">
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
        if(prefix == 2){
            html = $('#template-row2').html();
            html = html.replace('{{picture}}', item.picture_path);
            html = html.replace('{{room_name}}', item.room_name);
        }
        html = html.replace('{{name}}', item.name);
        html = html.replace('{{deleteHref}}', 'api.php?ctl=SoundCTL&method=remove&prefix='+prefix+'&id='+item.id);

        var el = $(html);
        $('.remove-btn', el).click(function(e){
            e.preventDefault();
            if(!window.confirm('Are you shure?')){
                return;
            }
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
    var tbodyPrefix2 = $('#tbody-prefix2');
    var tbodyPrefix3 = $('#tbody-prefix3');

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
        for(i in data.prefix2){
            item = data.prefix2[i];
            row = createRow(item, 2);
            tbodyPrefix2.append(row);
        }
        for(i in data.prefix3){
            item = data.prefix3[i];
            row = createRow(item, 3);
            tbodyPrefix3.append(row);
        }
    }, 'json');

    $('.add-btn').click(function(e){
        e.preventDefault();
        $('#addModal input').val("");

        var prefix = $(this).attr('prefix');
        $('#addModal input[name="prefix"]').val(prefix);
        if(prefix == 2){
            $('.show-prefix2').show();
        }
        else {
            $('.show-prefix2').hide();
        }
        $('#addModal').modal();
    });

    $('#add-form').submit(function(e){
        e.preventDefault();

        var prefix = $('#prefix-val').val();
        var name = $('.name-val').val();

        var send = new FormData();

        // set data to request
        send.append('prefix', prefix);
        send.append('name', name);

        if(name.trim() == ""){
            alert("Please fill in complete data.");
            return;
        }
        if(prefix == 2){
            var files = $('.picture-input')[0].files;
            if(files.length > 0){
                send.append('picture', files[0]);
            }
            else {
                alert("Please fill in complete data.");
                return;
            }
            send.append('room_name', $('.room_name-input').val());
        }

        var submitBtn = $('.submit-btn');
        submitBtn.prop('disabled', true);
        $.ajax({
            url: "api.php?ctl=SoundCTL&method=add",
            data: send,
            type: "POST",
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType,
            success: function(data){
                if(typeof data.error != "undefined"){
                    console.log(data);
                    return;
                }
                window.location.reload(true);
            },
            dataType: 'json'
        });
    });
});
</script>
<script type="text/template" id="template-row">
    <tr>
        <td>{{name}}</td>
        <td>
            <button class="remove-btn btn btn-danger" href="{{deleteHref}}">Delete</button>
        </td>
    </tr>
</script>
<script type="text/template" id="template-row2">
    <tr>
        <td>{{name}}</td>
        <td><img src="{{picture}}" width="64" height="64"></td>
        <td>{{room_name}}</td>
        <td>
            <button class="remove-btn btn btn-danger" href="{{deleteHref}}">Delete</button>
        </td>
    </tr>
</script>