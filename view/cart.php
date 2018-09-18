<?php
require_once 'model/cart_items.class.php';
require_once 'model/snowboards.class.php';
require_once 'model/orders.class.php';

if($_SESSION['username'] != 'Svečias' && $_SESSION['username'] != '') {
    $modulis = 'cart_item';
    $orderid = orders::getOrderByUser($_SESSION['username']);
    $menudata = cart_items::getItemsListCountCart($_SESSION['username'], $orderid);
    $list = cart_items::getItemsListCart($_SESSION['username'], $orderid);
    $sumprice = 0;
    if ($menudata > 0) {
        echo
            "<div class='container-cart'>"
            . "<div class='popup'>Krepšelyje yra " . $menudata . " prekės</div>"
            . "<div class='onHover'>"
            . "<table id='cart'>";
        foreach ($list as $key => $val) {
            $snowboard = snowboards::getSnowboard($val['fk_snowboard']);
            echo
            "<tr>"
            ."<td id='cart_first'><img id='snow_small' src='images/{$snowboard['image']}'</td>"
            ."<td id='cart_small'><p>{$snowboard['name']}</p></td>"
            ."<td id='cart_small'><p>{$snowboard['price']}</p></td>"
            ."<td id='cart_delete'><a href='#' onclick='showConfirmDialog(\"{$modulis}\", \"{$val['id']}\"); return false;' title=''>šalinti</a>&nbsp;</td>"
            ."</tr>";
            $sumprice += $snowboard['price'];
        }
        orders::updatePrice($sumprice,$orderid);
        echo
            "<tr><td colspan='4'><p id='cart_price_small'>Total price: {$sumprice}</p></td></tr>"
            . "<tr><td colspan='4'><p id='cart_create'><a style='color: blue;' href='".routing::getURL('order', 'edit', 'id='.$orderid)."'>MAKE AN ORDER</a></p></td></tr>"
            . "</table>"
            . "</div>"
            . "</div>";
    } else {
        echo "<div class='container-cart'>Krepšelis tuščias</div>";
    }
}