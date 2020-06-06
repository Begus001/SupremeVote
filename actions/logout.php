<?php

include_once("../config/config.php");

session_start();

if(session_destroy()) {
    redirect_msg("index.php", "logout");
} else {
    redirect_msg("voting.php", "no_logout");
}