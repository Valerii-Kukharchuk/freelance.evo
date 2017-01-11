<?php

//session_start();

include_once 'all_ads.php';

$dom = new DOMDocument();
$dom->loadHTML(file_get_contents('form_ad.php'));

if( !defined('ARR_PARAMS_AND_ELEM_ID') ) {
    define('ARR_PARAMS_AND_ELEM_ID', array(
        'seller_name' => 'fld_seller_name',
        'price' => 'fld_price',
        'title' => 'fld_title',
        'manager' => 'fld_manager',
        'email' => 'fld_email',
        'allow_mails' => 'allow_mails',
        'phone' => 'fld_phone',
        'location_id' => 'region',
        'metro_id' => 'fld_metro_id',
        'district_id' => 'fld_district_id',
        'road_id' => 'fld_road_id',
        'category_id' => 'fld_category_id',
        'description' => 'fld_description',
        'allow_mails' => 'allow_mails'
    ));
}

$key_session = filter_input(INPUT_GET, 'id');
if(isset($key_session)) {
    $ad = $_SESSION[$key_session];

    foreach ($ad as $key => $value) {
        $elem_id = get_elem_id_by_name_param($key);
        $elem = $dom->getElementById($elem_id);
        if(isset($elem) && $elem->hasAttribute('value') ) {
            $elem->setAttribute('value',$value);
        }
    }
    
    update_value_in_any_select($dom, $ad, 'location_id');
    update_value_in_any_select($dom, $ad, 'metro_id');
    update_value_in_any_select($dom, $ad, 'district_id');
    update_value_in_any_select($dom, $ad, 'road_id');
    update_value_in_any_select($dom, $ad, 'category_id');
    
    update_value_in_radio_person_or_company($dom, $ad['private']);
    
    update_value_in_textarea($dom, $ad, 'description');
    
    update_value_in_checkbox($dom, $ad, 'allow_mails');
    
}

function update_value_in_checkbox($dom, $ad, $key) {
    if(!array_key_exists($key, $ad)) {
        return;
    }
    
    $value = $ad[$key];
    $elem_id = get_elem_id_by_name_param($key);
    $elem = $dom->getElementById($elem_id);
    
    if($value == '1') {
        $elem->setAttribute('checked','');
    } else {
        $elem->removeAttribute('checked');
    }
}

function update_value_in_textarea($dom, $ad, $key) {
    $value = $ad[$key];
    $elem_id = get_elem_id_by_name_param($key);
    $elem = $dom->getElementById($elem_id);
    
    $elem->nodeValue = $value;
}

function update_value_in_radio_person_or_company($dom, $value) {
    $radio_person = $dom->getElementById('id_radio_private_person');
    $radio_company = $dom->getElementById('id_radio_company');
    
    if($value == '0') {
        if($radio_person->hasAttribute('checked')) {
           $radio_person->removeAttribute('checked');
        }
        $radio_company->setAttribute('checked','');
    } else {
        if($radio_company->hasAttribute('checked')) {
           $radio_company->removeAttribute('checked');
        }
        $radio_person->setAttribute('checked','');
    }
}

function update_value_in_any_select($dom, $ad, $key) {
    $value = $ad[$key];
    $elem_id = get_elem_id_by_name_param($key);
    $elem = $dom->getElementById($elem_id);
    $elem_list = $elem->getElementsByTagName('option');
    
    foreach ($elem_list as $option) {
        if($option->hasAttribute('selected')) {
           $option->removeAttribute('selected');
        }
        
        if($option->hasAttribute('value') 
                && $option->getAttribute('value') == $value) 
        {
            $option->setAttribute('selected','');
        }
    }
}


function get_elem_id_by_name_param($key) {
    return array_key_exists($key, ARR_PARAMS_AND_ELEM_ID) ? ARR_PARAMS_AND_ELEM_ID[$key] : '';
}


echo $dom->saveHTML();

//include_once 'all_ads.php';            
show_all_ads();

