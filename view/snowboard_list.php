<?php require('header.php'); ?>
    <ul id="pagePath">
        <li><a href="<?php echo routing::getURL(); ?>">Pradžia</a></li>
        <li>Snowboards</li>
    </ul>
    <div id="actions">
        <?php
        if ($_SESSION['userlevel'] == 5) {
            echo "<a href='" . routing::getURL($module, 'create') . "'>New Snowboard</a>";
        }
        ?>
    </div>
    <div class="float-clear"></div>

<?php if (!empty($delete_error)) { ?>
    <div class="errorBox">
        Snowboard has not been removed because someone wants to buy it
    </div>
<?php } ?>

<?php if (!empty($id_error)) { ?>
    <div class="errorBox">
        Klientas nerastas!
    </div>
<?php } $name = 'name'; $description = 'description'; $price = 'price';?>

    <table>
        <tr>
            <th>Image</th>
            <th><?php echo "<a href='".routing::getURL($module, 'sort', 'id='.$name)."'>Name</a>"; ?></th>
            <th><?php echo "<a href='".routing::getURL($module, 'sort', 'id='.$description)."'>Description</a>"; ?></th>
            <th style="padding-right: 0;"><?php echo "<a href='".routing::getURL($module, 'sort', 'id='.$price)."'>Price</a>"; ?></th>
            <th></th>
        </tr>
        <?php

        // suformuojame lentelę
        foreach ($data as $key => $val) {
            echo
                "<tr>"
                . "<td><img id='snow_list' src='images/{$val['image']}'</td>"
                . "<td><a href='" . routing::getURL($module, 'view', 'id=' . $val['id']), "'>{$val['name']}</a></td>"
                . "<td>{$val['description']}</td>"
                . "<td>{$val['price']}</td>"
                . "<td>";
            if ($_SESSION['userlevel'] == 5) {
                echo
                    "<a href='" . routing::getURL($module, 'edit', 'id=' . $val['id']), "' title=''>edit </a>"
                    . "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id']}\"); return false;' title=''>šalinti</a>&nbsp;";
            } else {
                if ($_SESSION['username'] != '' && $_SESSION['username'] != 'Svečias') {
                    echo "<a style='color: blue;' href='" . routing::getURL('cart_item', 'create', 'id=' . $val['id']) . "'>ADD TO CART</a>";
                }
                echo
                    "</td>"
                    . "</tr>\n";
            }
        }
        ?>
    </table>

<?php
// įtraukiame puslapių šabloną
require('paging.php');
require('footer.php');

