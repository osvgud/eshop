<?php require('header.php'); ?>
<ul id="pagePath">
    <li><a href="<?php echo routing::getURL(); ?>">Pradžia</a></li>
    <li><?php if(!empty($id)) echo "Prisijungimas"; else echo "Prisijungimas"; ?></li>
</ul>
<div class="float-clear"></div>
<div id="formContainer">
    <?php require("formErrors.php"); ?>
    <form action="" method="post">
        <fieldset>
            <legend>Naudotojo Registracija</legend>
            <p>
                <label class="field" for="username">Slapyvardis<?php echo in_array('username', $required) ? '<span> *</span>' : ''; ?></label>
                <?php if(empty($id)) { ?>
                    <input type="text" id="username" name="username" class="textbox-150" value="<?php echo isset($fields['username']) ? $fields['username'] : ''; ?>" />
                    <?php if(key_exists('username', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['username']} simb.)</span>"; ?>
                <?php } else { ?>
                    <span class="input-value"><?php echo $fields['username']; ?></span>
                    <input type="text" id="username" name="username" class="textbox-150 hidden" value="<?php echo isset($fields['username']) ? $fields['username'] : ''; ?>" />
                <?php } ?>
            </p>
            <p>
                <label class="field" for="password">Slaptažodis<?php echo in_array('password', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="password" id="password" name="password" class="textbox-150" value="<?php echo isset($fields['password']) ? $fields['password'] : ''; ?>" />
                <?php if(key_exists('password', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['password']} simb.)</span>"; ?>
            </p>
        </fieldset>
        <p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
        <p>
            <input type="submit" class="submit" name="submit" value="Išsaugoti">
        </p>
    </form>
</div>
<?php require('footer.php'); ?>
