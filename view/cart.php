<?php
require_once 'model/cart_items.class.php';
require_once 'model/snowboards.class.php';

if($_SESSION['username'] != 'Svečias' && $_SESSION['username'] != '') {
    $modulis = 'cart_item';
    $menudata = cart_items::getItemsListCount($_SESSION['username']);
    $list = cart_items::getItemsListCart($_SESSION['username']);
    $sumprice = 0;
    if ($menudata > 0) {
        echo
            "<div class='container-cart'>"
            . "<div class='popup' onclick='myFunction()'>Krepšelyje yra " . $menudata . " prekės</div>"
            . "<div class='onHover'>";
        foreach ($list as $key => $val) {
            $snowboard = snowboards::getSnowboard($val['fk_snowboard']);
            echo
            "<table>"
            ."<tr>"
            ."<td><img id='snow_small' src='images/{$snowboard['image']}'</td>"
            ."<td id='cart_small'><p>{$snowboard['name']}</p><p>{$snowboard['price']}</p></td>"
            ."<td><a href='#' onclick='showConfirmDialog(\"{$modulis}\", \"{$val['id']}\"); return false;' title=''>šalinti</a>&nbsp;</td>"
            ."</tr>"
            ."</table>";
            $sumprice += $snowboard['price'];
        }
        echo "<p id='cart_price_small'>Total price: {$sumprice}</p>"
            . "</div>"
            . "</div>";
    } else {
        echo "<div class='container-cart'>Krepšelis tuščias</div>";
    }
}