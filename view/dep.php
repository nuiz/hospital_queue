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
    <div><button>Sync department</button></div>
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
                <img data-src="holder.js/140x140" class="img-thumbnail" alt="140x140" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjcwIiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE0MHgxNDA8L3RleHQ+PC9zdmc+" style="width: 140px; height: 140px;">
            </td>
            <td>
                <input type="file">
            </td>
        </tr>
        <?php }?>
        </tbody>
    </table>
</div>
