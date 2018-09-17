<?php require('header.php'); ?>
<ul id="pagePath">
    <li><a href="<?php echo routing::getURL(); ?>">Pradžia</a></li>
    <li><a href="<?php echo routing::getURL($module); ?>">Orders</a></li>
    <li><?php if(!empty($id)) echo "Edit Order"; else echo "New Order"; ?></li>
</ul>
<div class="float-clear"></div>
<div id="formContainer">
    <?php require("formErrors.php"); ?>
    <form action="" method="post">
        <fieldset>
            <legend>Information About Order</legend>
            <p>
                <?php if(empty($id)) { ?>
                    <!--                    <input type="text" id="id" name="id" class="textbox-150" value="--><?php //echo isset($fields['id']) ? $fields['id'] : ''; ?><!--" />-->
                    <!--                    --><?php //if(key_exists('id', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['id']} simb.)</span>"; ?>
                <?php } else { ?>
                    <label class="field" for="id">ID<?php echo in_array('id', $required) ? '<span> *</span>' : ''; ?></label>
                    <span class="input-value"><?php echo $fields['id']; ?></span>
                    <input type="text" id="id" name="id" class="textbox-250 hidden" value="<?php echo isset($fields['id']) ? $fields['id'] : ''; ?>" />
                <?php } ?>
            </p>
            <p>
                <label class="field" for="first_name">First Name<?php echo in_array('first_name', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="first_name" name="first_name" class="textbox-250" value="<?php echo isset($fields['first_name']) ? $fields['first_name'] : ''; ?>" />
                <?php if(key_exists('first_name', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['first_name']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="last_name">Last Name<?php echo in_array('last_name', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="last_name" name="last_name" class="textbox-250" value="<?php echo isset($fields['last_name']) ? $fields['last_name'] : ''; ?>" />
                <?php if(key_exists('last_name', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['last_name']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="email">E-Mail<?php echo in_array('email', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="email" name="email" class="textbox-250" value="<?php echo isset($fields['email']) ? $fields['email'] : ''; ?>" />
                <?php if(key_exists('email', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['email']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="price">Price<?php echo in_array('price', $required) ? '<span> *</span>' : ''; ?></label>
                <span class="input-value"><?php echo $fields['price']; ?></span>
            </p>
        </fieldset>
        <p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
        <p>
            <input type="submit" class="submit" name="submit" value="Išsaugoti">
        </p>
    </form>
</div>
<?php require('footer.php'); ?>
