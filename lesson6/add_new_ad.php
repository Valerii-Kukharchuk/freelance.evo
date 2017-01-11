<?php

session_start();

function get_id_for_new_ad() {
    return 'key_'.time();
}

$_SESSION[get_id_for_new_ad()] = $_POST;

header("Location: show_form_ad.php");
die();