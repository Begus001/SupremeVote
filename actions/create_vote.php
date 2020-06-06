<?php

include_once("../config/config.php");

session_start();

date_default_timezone_set("Europe/Vienna");

set_time_limit(60);

if (!isset($_POST['name']) || $_POST['name'] == "") {
    redirect_msg("create_vote.php", "no_name");
}

if (!isset($_POST['pw']) || $_POST['pw'] == "") {
    redirect_msg("create_vote.php", "no_pw");
}

$name = $_POST['name'];
$pw = $_POST['pw'];

if(sha1($pw) != sha1(ADMIN_PW)) {
    redirect_msg("create_vote.php", "inv_pw");
} else {
    $_SESSION['admin'] = true;
}

if (!isset($_POST['multiple'])) {
    $multiple = 0;
} else {
    $multiple = 1;
}

if (!isset($_POST['limit']) || $_POST['limit'] == "") {
    redirect_msg("create_vote.php", "no_limit");
}

$limit = new DateTime(str_replace("T", " ", $_POST['limit']) . ":00");

if($limit < new DateTime()) {
    redirect_msg("create_vote.php", "inv_limit");
}

$i = 0;
$choices = array();
$images = array();

while (true) {
    if (isset($_POST["choice$i"])) {

        array_push($choices, $_POST["choice$i"]);
        array_push($images, $_FILES["img$i"]);

        if ($images[$i]['size'] > 8388608) {
            redirect_msg("create_vote.php", "big_img");
        }

        if (!($images[$i]['type'] == "image/png" || $images[$i]['type'] == "image/jpg" || $images[$i]['type'] == "image/jpeg" || $images[$i]['type'] == "")) {
            redirect_msg("create_vote.php", "inv_file");
        }

        if ($choices[$i] == "" && $images[$i]['error'] == 4) {
            redirect_msg("create_vote.php", "inv_vote");
        }

        $i++;
    } else {
        break;
    }
}

if (mysqli_connect_error($sqlconn)) {
    redirect_msg("create_vote.php", "db_con_err");
}

$ids = mysqli_query($sqlconn, "SELECT id FROM votes");

if (!$ids) {
    redirect_msg("create_vote.php", "db_quy_err");
}

$id = 0;

for ($i = 0; $i < mysqli_num_rows($ids); $i++) {
    if (mysqli_fetch_assoc($ids)['id'] == $i) {
        $id++;
    } else {
        break;
    }
}

mkdir("../votes/$id");

for ($i = 0; $i < sizeof($images); $i++) {
    if ($images[$i]['error'] == 0) {
        $ext = strtolower(explode('/', $images[$i]['type'])[1]);
        move_uploaded_file($images[$i]['tmp_name'], "../votes/$id/$i.$ext");
        sleep(0.5);
        if (!file_exists("../votes/$id/$i.$ext")) {
            redirect_msg("create_vote.php", "upload_err");
        }
    }
}

$s_choices = mysqli_real_escape_string($sqlconn, utf8_encode(serialize($choices)));
$s_name = mysqli_real_escape_string($sqlconn, utf8_encode($name));
$s_limit = $limit->format("Y-m-d H:i:s");

$score = array();

foreach ($choices as $choice) {
    array_push($score, 0);
}

$s_score = serialize($score);

$query = "INSERT INTO votes (id, name, time_limit, choices, multiple, score) VALUES ($id, '$s_name', '$s_limit', '$s_choices', $multiple, '$s_score')";

if (!mysqli_query($sqlconn, $query)) {
    redirect_msg("create_vote.php", "db_quy_err");
}

redirect_msg("../voting.php", "created");
