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
    min-width: 300px;
    min-height: 300px;
}
</style>
<div>
    <h3>Default setting</h3>
    <form role="form" class="form-setting">
        <div class="bg-block"></div>
        <div class="form-group">
            <label for="exampleInputFile">Background</label>
            <input class="form-control input-background" type="file">
            <p class="help-block">jpg, jpeg, png only</p>
        </div>
        <div class="checkbox">
            <label>
                <input class="show_people_name-checkbox" type="checkbox"> Show people name
            </label>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
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

            $('.show_people_name-checkbox').prop("checked", data.show_people_name);
        });

        $('.form-setting').submit(function(e){
            e.preventDefault();
            var send = new FormData();
            var files = $('.input-background')[0].files;
            if(files.length > 0){
                send.append('background', files[0]);
            }
            send.append('show_people_name', $('.show_people_name-checkbox').prop("checked")? 1: 0);

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