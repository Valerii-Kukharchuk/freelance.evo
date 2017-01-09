<?php

//include_once 'utils.php';

function get_id_for_new_ad() {
//    static $ad_id = 0;
//    return ++$ad_id;
    return 'key_'.time();
}

//------------------------------------------------------------
//------------------------------------------------------------

//if( is_session_started() === FALSE ) {
    session_start();
//}

$_SESSION[get_id_for_new_ad()] = $_POST;

header("Location: show_form_ad.php");
die();