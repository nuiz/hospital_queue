<?php
/**
 * Created by PhpStorm.
 * User: Papangping
 * Date: 10/26/14
 * Time: 10:22 PM
 */


?>
<style type="text/css">
.bg-block img {
    width: 140px;
    height: 140px;
}
</style>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Default setting</h3>
    </div>
    <div class="panel-body">
        <form role="form" class="form-setting">
            <div class="bg-block"></div>
            <div class="form-group">
                <label for="exampleInputFile"><h4>Background Default</h4></label>
                <input class="form-control input-background" type="file">
                <p></p>
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<!--                    <h4>Warning!</h4>-->
                    jpg, jpeg, png only
                </div>
            </div>
            <div>
            <div class="bs-callout bs-callout-info">
                <h4>Other Function</h4>
                <p>
                    <input class="show_people_picture-checkbox" type="checkbox"> &nbsp; Show People Picture
                </p>
                <p style="display: none;">
                    <input class="hide_after_call-checkbox" type="checkbox"> &nbsp; Hide Queue after call
                </p>
                <p>
                    <input class="call_after_scan-checkbox" type="checkbox"> &nbsp; Call after scan
                </p>
                <p>
                    Auto Hide Time <input class="time-auto-hide" type="text" style="width: 40px" > &nbsp;  min
                </p>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        var bgBlock = $('.bg-block');

        // Action on Click
        $.isLoading({ text: "Loading" });

        $.post("api.php?ctl=SettingCTL&method=get", {}, function(data){
            $.isLoading( "hide" );
            console.log(data);

            var img = $('<img>');
            img.attr('src', data.background_path);

            bgBlock.html('');
            bgBlock.append(img);

            // set view from response
            $('.show_people_picture-checkbox').prop("checked", data.show_people_picture);
            $('.hide_after_call-checkbox').prop("checked", data.hide_after_call);
            $('.call_after_scan-checkbox').prop("checked", data.call_after_scan);
            $('.time-auto-hide').val(data.auto_hide_time);
        });

        $('.form-setting').submit(function(e){
            e.preventDefault();
            var send = new FormData();
            var files = $('.input-background')[0].files;
            if(files.length > 0){
                send.append('background', files[0]);
            }

            // set data to request
            send.append('show_people_picture', $('.show_people_picture-checkbox').prop("checked")? 1: 0);
            send.append('hide_after_call', $('.hide_after_call-checkbox').prop("checked")? 1: 0);
            send.append('call_after_scan', $('.call_after_scan-checkbox').prop("checked")? 1: 0);
            send.append('auto_hide_time', $('.time-auto-hide').val());

            $.isLoading({ text: "Loading" });

            $.ajax({
                url: "api.php?ctl=SettingCTL&method=edit",
                type: "POST",
                data: send,
                processData: false,  // tell jQuery not to process the data
                contentType: false,   // tell jQuery not to set contentType,
                success: function(data){
                    $.isLoading( "hide" );
                    console.log(data);
                    if(typeof data.error != 'undefined'){
                        alert(data.error.message);
                        return;
                    }
                    window.location.reload(false);
                },
                dataType: 'json'
            });
        });
    });
</script>