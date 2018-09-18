<?php require('header.php'); ?>
<ul id="pagePath">
    <li><a href="<?php echo routing::getURL(); ?>">Pradžia</a></li>
    <li><a href="<?php echo routing::getURL($module); ?>">Snowboards</a></li>
    <li><?php if(!empty($id)) echo $data['name']; else echo "New Snowboard"; ?></li>
</ul>
<div class="float-clear"></div>
<div class="content-wrap">
    <table class="product-content-table">
        <tbody>
                <?php
                $nextModule = 'order';
                echo
                    "<tr>"
                    ."<p class='title'>{$data['name']}</p>"
                    ."</tr>"
                    ."<tr>"
                    ."<td id='image'><img id='snow_view' src='images/{$data['image']}'</td>"
                    ."<td>"
                        ."<div class='waranty'>"
                        ."<p><b style='font-weight:bold;'>Warranty:</b> {$data['warranty']} Years</p>"
                        ."<p><b style='font-weight:bold;'>Description:</b> {$data['description']}</p>"
                        ."<p id='price'><b style='font-weight:bold;'>Price:</b> {$data['price']}$</p>"
                        ."<p id='add_to_cart'><a style='color: blue;' href='".routing::getURL('cart_item', 'create', 'id='.$data['id'])."'>ADD TO CART</a></p>"
                        ."</div>"
                    ."</td>"
                    ."</tr>"
                ?>
        </tbody>
    </table>
</div>
<?php require('footer.php'); ?>
