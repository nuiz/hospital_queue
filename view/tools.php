<?php
/**
 * Created by PhpStorm.
 * User: Papangping
 * Date: 10/26/14
 * Time: 10:22 PM
 */
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Tools </h3>
    </div>
    <div class="panel-body">
        <button class="clear-btn">Clear queue</button>
        <button class="hide-btn">Hide all queue</button>
        <button class="sync-btn">Sync all queue</button>
    </div>
</div>


<script type="text/javascript">
    $(function(e){
        $('.clear-btn').click(function(e){
            e.preventDefault();
            if(window.confirm('Are you shure?')){
                $.isLoading({ text: "Loading" });
                $.post("api.php?ctl=ToolCTL&method=clearQue", {}, function(data){
                    $.isLoading("hide");
                }, 'json');
            }
        });

        $('.hide-btn').click(function(e){
            e.preventDefault();
            if(window.confirm('Are you shure?')){
                $.isLoading({ text: "Loading" });
                $.post("api.php?ctl=ToolCTL&method=hideAll", {}, function(data){
                    $.isLoading("hide");
                }, 'json');
            }
        });

        $('.sync-btn').click(function(e){
            e.preventDefault();
            if(window.confirm('Are you shure?')){
                $.isLoading({ text: "Loading" });
                $.post("api.php?ctl=SyncCTL&method=que", {}, function(data){
                    $.isLoading("hide");
                }, 'json');
            }
        });
    });
</script>