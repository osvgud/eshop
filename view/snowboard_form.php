<?php require('header.php'); ?>
<ul id="pagePath">
    <li><a href="<?php echo routing::getURL(); ?>">Pradžia</a></li>
    <li><a href="<?php echo routing::getURL($module); ?>">Klientai</a></li>
    <li><?php if(!empty($id)) echo "Kliento redagavimas"; else echo "New Snowboard"; ?></li>
</ul>
<div class="float-clear"></div>
<div id="formContainer">
    <?php require("formErrors.php"); ?>
    <form action="" method="post">
        <fieldset>
            <legend>Kliento informacija</legend>
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
                <label class="field" for="image">Image<?php echo in_array('image', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="file" id="image" name="image" class="textbox-250" value="<?php echo isset($fields['image']) ? $fields['image'] : ''; ?>" />
                <?php if(key_exists('image', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['image']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="name">Name<?php echo in_array('name', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="name" name="name" class="textbox-250" value="<?php echo isset($fields['name']) ? $fields['name'] : ''; ?>" />
                <?php if(key_exists('name', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['name']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="price">Price<?php echo in_array('price', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="price" name="price" class="textbox-250" value="<?php echo isset($fields['price']) ? $fields['price'] : ''; ?>" />
                <?php if(key_exists('price', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['price']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="description">Description<?php echo in_array('description', $required) ? '<span> *</span>' : ''; ?></label>
                <textarea id="description" name="description" rows="10" cols="30" value="<?php echo isset($fields['description']) ? $fields['description'] : ''; ?>"></textarea>
                <?php if(key_exists('description', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['description']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="warranty">Waranty<?php echo in_array('warranty', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="warranty" name="warranty" class="textbox-250" value="<?php echo isset($fields['warranty']) ? $fields['warranty'] : ''; ?>" />
                <?php if(key_exists('warranty', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['warranty']} simb.)</span>"; ?>
            </p>
        </fieldset>
        <p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
        <p>
            <input type="submit" class="submit" name="submit" value="Išsaugoti">
        </p>
    </form>
</div>
<?php require('footer.php'); ?>
