<?php

include_once("config/config.php");

session_start();

if (!isset($_POST['multiple']) || !isset($_POST['id'])) {
    redirect_msg("voting.php", "inv_vote");
}

$multiple = $_POST['multiple'];
$id = $_POST['id'];

if (!$sqlconn) {
    redirect_msg("voting.php", "db_con_err");
}

if ($_POST['del'] == "x") {

    echo "<form action='actions/delete.php' method='post' enctype='multipart/form-data'>";

    if (isset($_SESSION['admin']) && $_SESSION['admin']) {
        echo "<input type='password' name='pw' placeholder='Administrator Passwort' value='".ADMIN_PW."'>";
    } else {
        echo "<input type='password' name='pw' placeholder='Administrator Passwort'>";
    }

    echo "<input type='hidden' name='id' value='$id'>\n";
    echo "<input type='submit' value='Abstimmung Löschen'>";
    echo "</form>";

    die();
}

$query = mysqli_query($sqlconn, "SELECT * FROM votes WHERE id=$id");

if (!$query) {
    redirect_msg("voting.php", "db_quy_err");
}

$vote = mysqli_fetch_assoc($query);

$voted_ips = unserialize($vote['voted_ips']);
$voted_users = unserialize($vote['voted_users']);
$score = unserialize($vote['score']);
$num_choices = sizeof(unserialize(utf8_decode($vote['choices'])));

$user = $_SESSION['name'];

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}

foreach ($voted_users as $voted_user) {
    if ($voted_user == $user) {
        redirect_msg("voting.php", "already_voted#vote$id");
    }
}

foreach ($voted_ips as $voted_ip) {
    if ($voted_ip == $ip) {
        redirect_msg("voting.php", "already_voted#vote$id");
    }
}

if ($multiple) {

    $choices = array();

    for ($i = 0; $i < $num_choices; $i++) {

        if (isset($_POST["choice$i"])) {
            array_push($choices, $i);
        }
    }

    echo "k{$num_choices}k";
    print_r($choices);

    foreach ($choices as $choice) {
        $score[$choice]++;
    }

    print_r($score);
} else {

    if (!isset($_POST['choice'])) {
        redirect_msg("voting.php", "no_choice#vote$id");
    }

    $choice = $_POST['choice'];

    $score[$choice]++;
}

if (isset($ip)) {
    array_push($voted_ips, $ip);
}
array_push($voted_users, $user);

$s_voted_ips = serialize($voted_ips);
$s_voted_users = serialize($voted_users);
$s_score = serialize($score);

$query = "UPDATE votes SET voted_ips = '$s_voted_ips', voted_users = '$s_voted_users', score = '$s_score' WHERE id = $id";

if (!mysqli_query($sqlconn, $query)) {
    redirect_msg("voting.php", "db_quy_err#vote$id");
}

redirect_msg("voting.php", "voted#vote$id");
