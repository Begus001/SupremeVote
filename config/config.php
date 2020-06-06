<?php

define("ADMIN_PW", "4209111337");

define("DB_ADDR", "127.0.0.1");
define("DB_USER", "root");
define("DB_PW", "4209111337");
define("DB_NAME", "supreme_voting");
$sqlconn = mysqli_connect(DB_ADDR, DB_USER, DB_PW, DB_NAME);

function redirect_msg($root_path, $msg)
{
    header("Location: /$root_path?msg=$msg");
    die();
}

function redirect($root_path) {
    header("Location: /$root_path");
    die();
}
