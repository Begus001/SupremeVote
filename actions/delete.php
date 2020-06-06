<?php

include_once("../config/config.php");

session_start();

if (!$sqlconn) {
    redirect_msg("voting.php", "db_con_err");
}

if (!isset($_POST['pw']) || $_POST['pw'] == "") {
    redirect_msg("voting.php", "no_pw");
}

if(!isset($_POST['id'])) {
    redirect_msg("voting.php", "no_id");
}

$pw = $_POST['pw'];
$id = $_POST['id'];

if(sha1(ADMIN_PW) != sha1($pw)) {
    redirect_msg("voting.php", "inv_pw");
}

$_SESSION['admin'] = true;

$votes_dir = "../votes/$id";

foreach(scandir($votes_dir) as $file) {
    if (!is_dir($votes_dir . "/$file")) {
        unlink($votes_dir . "/$file");
    }
}

rmdir($votes_dir);

$query = "DELETE FROM votes WHERE id = $id";

if(!mysqli_query($sqlconn, $query)) {
    redirect_msg("voting.php", "db_quy_err");
}

redirect_msg("voting.php", "deleted");
