<?php

include_once("config/config.php");

session_start();

if (!$sqlconn) {
    redirect_msg("index.php", "db_con_err");
}

if (isset($_SESSION['name']) && isset($_SESSION['pw'])) {
    $name = $_SESSION['name'];
    $pw = $_SESSION['pw'];

    $query = "SELECT password FROM users WHERE name='$name' and password='$pw'";
    $result = mysqli_query($sqlconn, $query);

    if (mysqli_num_rows($result) > 0) {
        redirect("voting.php");
    }
}
