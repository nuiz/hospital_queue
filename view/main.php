<?php
/**
 * Created by PhpStorm.
 * User: Papangping
 * Date: 10/26/14
 * Time: 10:22 PM
 */
?>
<style type="text/css">
.tab {
    display: none;
}
</style>
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
            <tbody class="hide-queue-list">
            <tr>
                <td>1111111</td>
                <td>ทดสอบ ทดสอบ</td>
                <td>10:10</td>
                <td>
                    <button>Call</button>
                    <button>Hide</button>
                    <button>Skip</button>
                </td>
            </tr>
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
            <tr>
                <td>2222222</td>
                <td>ทดสอบ ทดสอบ</td>
                <td>10:10</td>
                <td>
                    <button>Call</button>
                    <button>Hide</button>
                    <button>Skip</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(function(){
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