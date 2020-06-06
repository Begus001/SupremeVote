<?php

include_once("../config/config.php");
session_start();

if (!isset($_POST['name'])) {
    redirect_msg("index.php", "no_name");
} elseif (!isset($_POST['pw'])) {
    redirect_msg("index.php", "no_pw");
}

$name = $_POST['name'];
$pw = $_POST['pw'];

if ($name == "") {
    redirect_msg("index.php", "no_name");
} elseif ($pw == "") {
    redirect_msg("index.php", "no_pw");
}

$pw = sha1($pw);

if(!$sqlconn) {
    redirect_msg("index.php", "db_con_err");
}

$query = "SELECT password FROM users WHERE name='$name'";
$result = mysqli_query($sqlconn, $query);

if(mysqli_num_rows($result) <= 0) {
    redirect_msg("index.php", "inv_user");
}

$db_pw = mysqli_fetch_assoc($result)['password'];

if($pw != $db_pw) {
    redirect_msg("index.php", "inv_pw");
}

$_SESSION['name'] = $name;
$_SESSION['pw'] = $pw;

redirect_msg("voting.php", "login");
