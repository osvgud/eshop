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
                        ."<p>Warranty: {$data['warranty']} Years</p>"
                        ."<p>Price: {$data['price']}$</p>"
                        ."</div>"
                    ."</td>"
                    ."</tr>"
                    ."<tr>"
                    ."<a href='".routing::getURL($nextModule, 'create')."'>ORDER NOW</a>"
                    ."</tr>"
                ?>
        </tbody>
    </table>
</div>
<?php require('footer.php'); ?>
