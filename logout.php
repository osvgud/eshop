<?php
session_start();
$_SESSION["username"] = "";
$_SESSION["userlevel"] = 1;
header('location: index.php');