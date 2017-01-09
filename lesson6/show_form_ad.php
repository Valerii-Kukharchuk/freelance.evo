<?php

session_start();

$dom = new DOMDocument();
$dom->loadHTML(file_get_contents('form_ad.php'));

if( !defined('ARR_PARAMS_AND_ELEM_ID') ) {
    define('ARR_PARAMS_AND_ELEM_ID', array(
        'seller_name' => 'fld_seller_name',
        'price' => 'fld_price',
        'title' => 'fld_title'
    ));
}

$key_session = filter_input(INPUT_GET, 'id');
if(isset($key_session)) {
    $ad = $_SESSION[$key_session];

//    $dom = new DOMDocument();
//    $dom->loadHTML(file_get_contents('form_ad.php'));
    //$dom->loadHTMLFile(file_get_contents('http://freelance.evo/lesson6/form_ad.php‌​'));

    foreach ($ad as $key => $value) {
        $elem_id = get_elem_id_by_name_param($key);
        $elem = $dom->getElementById($elem_id);
        if(isset($elem) && $elem->hasAttribute('value') ) {
            $elem->setAttribute('value',$value);
        }
    }
}
       
function get_elem_id_by_name_param($key) {
    return array_key_exists($key, ARR_PARAMS_AND_ELEM_ID) ? ARR_PARAMS_AND_ELEM_ID[$key] : '';
}


echo $dom->saveHTML();

include_once 'all_ads.php';            
show_all_ads();

