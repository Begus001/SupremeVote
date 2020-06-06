<?php

include_once("../config/config.php");

session_start();

if (!isset($_POST['name'])) {
    redirect_msg("register.php", "no_name");
} elseif (!isset($_POST['pw'])) {
    redirect_msg("register.php", "no_pw");
} elseif (!isset($_POST['cpw'])) {
    redirect_msg("register.php", "no_cpw");
}

$name = $_POST['name'];
$pw = $_POST['pw'];
$cpw = $_POST['cpw'];

if ($name == "") {
    redirect_msg("register.php", "no_name");
} elseif ($pw == "") {
    redirect_msg("register.php", "no_pw");
} elseif ($cpw == "") {
    redirect_msg("register.php", "no_cpw");
} elseif ($pw != $cpw) {
    redirect_msg("register.php", "pw_mismatch");
}

$pw = sha1($pw);

if (!$sqlconn) {
    redirect_msg("register.php", "db_con_err");
}

$names = mysqli_query($sqlconn, "SELECT name FROM users");

for ($i = 0; $i < mysqli_num_rows($names); $i++) {
    if ($name == mysqli_fetch_assoc($names)['name']) {
        redirect_msg("register.php", "name_taken");
    }
}

$query = "INSERT INTO users (name, password) VALUES ('$name', '$pw')";

if (!mysqli_query($sqlconn, $query)) {
    redirect_msg("register.php", "db_quy_err");
}

redirect_msg("register.php", "registered");
