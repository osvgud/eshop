<?php require('header.php'); ?>
    <ul id="pagePath">
        <li><a href="<?php echo routing::getURL(); ?>">Pradžia</a></li>
        <li>Orders</li>
    </ul>
    <div id="actions">
        <a href='<?php echo routing::getURL($module, 'create'); ?>'>New Snowboard</a>
    </div>
    <div class="float-clear"></div>

<?php if (!empty($delete_error)) { ?>
    <div class="errorBox">
        Klientas nebuvo pašalintas, nes turi užsakymą (-ų).
    </div>
<?php } ?>

<?php if (!empty($id_error)) { ?>
    <div class="errorBox">
        Klientas nerastas!
    </div>
<?php } $fname = 'first_name'; $lname = 'last_name'; $sprice = 'sum_price';?>

    <table>
        <tr>
            <th><?php echo "<a href='".routing::getURL($module, 'sort', 'id='.$fname)."'>First Name</a>"; ?></th>
            <th><?php echo "<a href='".routing::getURL($module, 'sort', 'id='.$lname)."'>Last Name</a>"; ?></th>
            <th><?php echo "<a href='".routing::getURL($module, 'sort', 'id='.$sprice)."'>Sum Price</a>"; ?></th>
        </tr>
        <?php
        // suformuojame lentelę
        $k = 0;
        foreach ($data as &$val) {
            $next = next($data);
            if ($k == 0) {
                echo
                    "<tr>"
                    . "<td>{$val['first_name']}</td>"
                    . "<td>{$val['last_name']}</td>"
                    . "<td>{$val['sum_price']}</td>"
                    . "<tr>"
                    . "<td colspan='3'><input type='checkbox'  id='spoiler" . $val['order_id'] . "' />"
                    . "<label for='spoiler" . $val['order_id'] . "'>Order Items</label>"
                    . "<div class='spoiler'>"
                    . "<table>"
                    . "<th>Snowboard Name</th>"
                    . "<th>Snowboard Price</th>"
                    . "<th></th>";
            }
            if ($next && $next['order_id'] == $val['order_id']) {
                echo
                    "<tr>"
                    . "<td><a href='" . routing::getURL('snowboard', 'view', 'id=' . $val['snowboard_id']), "'>{$val['snowboard_name']}</a></td>"
                    . "<td>{$val['snowboard_price']}</td>"
                    . "<td><img id='snow_list' src='images/{$val['image']}'</td>"
                    . "</tr>";
                $k = $k + 1;
            } else {
                echo
                    "<tr>"
                    . "<td><a href='" . routing::getURL('snowboard', 'view', 'id=' . $val['snowboard_id']), "'>{$val['snowboard_name']}</a></td>"
                    . "<td>{$val['snowboard_price']}</td>"
                    . "<td><img id='snow_list' src='images/{$val['image']}'</td>"
                    . "</tr>"
                    . "</table></div></td></tr></tr>";
                $k = 0;
            }
        }
        ?>
    </table>

<?php
// įtraukiame puslapių šabloną
require('paging.php');
require('footer.php');

