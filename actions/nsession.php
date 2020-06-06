<?php

include_once("config/config.php");

session_start();

if(!$sqlconn) {
    redirect_msg("index.php", "db_con_err");
}

if(!isset($_SESSION['name']) || !isset($_SESSION['pw'])) {
    redirect_msg("index.php", "no_login");
}

$name = $_SESSION['name'];
$pw = $_SESSION['pw'];

$query = "SELECT password FROM users WHERE name='$name'";
$result = mysqli_query($sqlconn, $query);

if(mysqli_num_rows($result) <= 0) {
    session_destroy();
    redirect_msg("index.php", "inv_login");
}

if(mysqli_fetch_assoc($result)['password'] != $pw) {
    session_destroy();
    redirect_msg("index.php", "inv_login");
}
