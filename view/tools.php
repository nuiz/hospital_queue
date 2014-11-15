<?php
/**
 * Created by PhpStorm.
 * User: Papangping
 * Date: 10/26/14
 * Time: 10:22 PM
 */
?>
<button class="clear-btn">Clear queue</button>
<button class="hide-btn">Hide all queue</button>
<button class="sync-btn">Sync all queue</button>

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

        var callNumber = 1;
        function callSync(){
            $.isLoading({ text: "Loading..." + callNumber });
            $.post("api.php?ctl=SyncCTL&method=que", {}, function(data){
                if(data == 0){
                    $.isLoading("hide");
                    callNumber = 1;
                }
                else {
                    callNumber++;
                    callSync();
                }
            }, 'json');
        }

        $('.sync-btn').click(function(e){
            e.preventDefault();
            if(window.confirm('Are you shure?')){
                callSync();
            }
        });
    });
</script>