<?php

$menuLeft = array(
    'snowboard' => 'Snowboards',
    'order' => 'Orders'
);

if($_SESSION["username"] == "") {
    $_SESSION["username"] = "Svečias";
}

$menuRight = array(
    'user' => 'Register',
    'login' => 'Login'
);
?>
<script>
    // When the user clicks on div, open the popup
    function myFunction() {
        var popup = document.getElementById("myPopup");
        popup.classList.toggle("show");
    }
</script>
<div id="topMenu">
    <ul class="float-left">
        <?php
        foreach ($menuLeft as $key => $val) {
            echo "<li><a href='", routing::getURL($key), "' title='${val}'";
            if ($module == $key) {
                echo ' class="active"';
            }
            echo ">${val}</a></li>";
        }
        ?>
    </ul>

    <ul class="float-right">
        <?php
        if($_SESSION["username"] == "" || $_SESSION["username"] == "Svečias")
            foreach ($menuRight as $key => $val) {
                echo "<li><a href='", routing::getURL($key), "' title='${val}'";
                if ($module == $key) {
                    echo ' class="active"';
                }
                echo ">${val}</a></li>";
            }
        else{
            echo "<li>Prisijungęs narys: ".$_SESSION["username"]."</strong></li>";
            echo "<li><div><a href='logout.php'>Atsijungti</a></li>";
        }
        ?>
    </ul>
</div>
