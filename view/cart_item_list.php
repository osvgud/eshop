<?php require('header.php'); ?>
    <ul id="pagePath">
        <li><a href="<?php echo routing::getURL(); ?>">Pradžia</a></li>
        <li>Orders</li>
    </ul>
    <div id="actions">
        <a href='<?php echo routing::getURL($module, 'create'); ?>'>New Snowboard</a>
    </div>
    <div class="float-clear"></div>

<?php if(!empty($delete_error)) { ?>
    <div class="errorBox">
        Klientas nebuvo pašalintas, nes turi užsakymą (-ų).
    </div>
<?php } ?>

<?php if(!empty($id_error)) { ?>
    <div class="errorBox">
        Klientas nerastas!
    </div>
<?php } ?>

    <table>
        <tr>
            <th>FK User</th>
            <th>FK Snowboard</th>
            <th></th>
        </tr>
        <?php

        // suformuojame lentelę
        foreach($data as $key => $val) {
            echo
                "<tr>"
                . "<td>{$val['fk_user']}</td>"
                . "<td>{$val['fk_snowboard']}</td>"
                . "<td>"
//                . "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['asmens_kodas']}\"); return false;' title=''>šalinti</a>&nbsp;"
//                . "<a href='" . routing::getURL($module, 'edit', 'id=' . $val['id']), "' title=''>užsakyti</a>"
                . "</td>"
                . "</tr>\n";
        }
        ?>
    </table>

<?php
// įtraukiame puslapių šabloną
require('paging.php');
require('footer.php');

