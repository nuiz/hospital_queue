<?php
/**
 * Created by PhpStorm.
 * User: Papangping
 * Date: 10/26/14
 * Time: 10:22 PM
 */

$ctl = new \Main\CTL\SpcltyCTL();
$items = $ctl->gets();
?>
<div>
    <h3>Department setting</h3>
    <div><button id="sync-btn">Sync department</button></div>
</div>
<hr>
<div>
    <table class='table table-bordered'>
        <thead>
        <tr>
            <th>
                Name
            </th>
            <th>
                background call
            </th>
            <th>
                Upload background
            </th>
        </tr>
        </thead>
        <tbody class="hide-queue-list">
        <?php foreach($items as $key=> $item){?>
        <tr>
            <td><?php echo $item->getName();?></td>
            <td>
                <?php if(is_null($item->getBackgroundPath())) {?>
                <img data-src="holder.js/140x140" class="img-thumbnail" alt="140x140" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjcwIiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE0MHgxNDA8L3RleHQ+PC9zdmc+" style="width: 140px; height: 140px;">
                <?php }else {?>
                <img width="140" height="140" src="<?php echo $item->getBackgroundPath();?>">
                <?php }?>
            </td>
            <td>
                <form class="edit-form">
                    <input name="id" type="hidden" value="<?php echo $item->getId();?>">
                    <input name="background" type="file"> <button class="btn" type="submit">upload</button>
                </form>
            </td>
        </tr>
        <?php }?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
$(function(e){
    $('#sync-btn').click(function(e){
        e.preventDefault();
        if(window.confirm('Are you shure?')){
            $.isLoading({ text: "Loading" });
            $.post("api.php?ctl=SyncCTL&method=spclty", {}, function(data){
//                $.isLoading("hide");
                window.location.reload(true);
            }, 'json');
        }
    });

    $('.edit-form').submit(function(e){
        e.preventDefault();

        var fd = new FormData(this);

        $.isLoading({ text: "Loading" });
        $.ajax({
            url: "api.php?ctl=SpcltyCTL&method=edit",
            type: "POST",
            data: fd,
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