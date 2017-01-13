<?php

session_start();

//--- names of available actions with form_add
const NAME_PARAM_ACTION = 'action';
const ACTION_ADD = 'add';
const ACTION_REMOVE = 'remove';
const ACTION_FILL_FORM = 'fill_form';

const CITIES = array(
    "641780" => 'Новосибирск',
    "641490" => 'Барабинск',
    "641510" => 'Бердск',
    "641600" => 'Искитим',
    "641630" => 'Колывань',
    "641680" => 'Краснообск',
    "641710" => 'Куйбышев',
    "641760" => 'Мошково',
    "641790" => 'Обь',
    "641800" => 'Ордынское',
    "641970" => 'Черепаново'
);

const METRO_STATIONS = array(
    "2028" => 'Берёзовая роща',
    "2018" => 'Гагаринская',
    "2017" => 'Заельцовская',
    "2029" => 'Золотая Нива',
    "2019" => 'Красный проспект',
    "2027" => 'Маршала Покрышкина',
    "2021" => 'Октябрьская',
    "2025" => 'Площадь Гарина-Михайловского',
    "2020" => 'Площадь Ленина',
    "2024" => 'Площадь Маркса',
    "2022" => 'Речной вокзал',
    "2026" => 'Сибирская',
    "2023" => 'Студенческая'
);

//keys of showing_ad
const SHOWING_AD_RADIO_PRIVATE_PERSON = 'radio_private_person';
const SHOWING_AD_RADIO_COMPANY = 'radio_company';
const SHOWING_AD_SELLER_NAME = 'seller_name';
const SHOWING_AD_MANAGER = 'manager';
const SHOWING_AD_EMAIL = 'email';
const SHOWING_AD_ALLOW_MAILS = 'allow_mails';
const SHOWING_AD_PHONE = 'phone';
const SHOWING_AD_LOCATION_ID = 'location_id';
const SHOWING_AD_METRO_ID = 'metro_id';
const SHOWING_AD_TITLE = 'title';
const SHOWING_AD_PRICE = 'price';


const FORM_PARAMS_PRIVATE = 'private';

const ARR_FORM_PARAMS = array(
    SHOWING_AD_SELLER_NAME,
    SHOWING_AD_MANAGER,
    SHOWING_AD_EMAIL,
    SHOWING_AD_ALLOW_MAILS,
    SHOWING_AD_PHONE,
    SHOWING_AD_LOCATION_ID,
    SHOWING_AD_METRO_ID,
    SHOWING_AD_TITLE,
    SHOWING_AD_PRICE
);

//array contains values of all placeholders for the 'form_add'
$showing_ad = array(
    SHOWING_AD_RADIO_PRIVATE_PERSON => 'checked=""',
    SHOWING_AD_RADIO_COMPANY => '',
    SHOWING_AD_SELLER_NAME => '',
    SHOWING_AD_MANAGER => '',
    SHOWING_AD_EMAIL => '',
    SHOWING_AD_ALLOW_MAILS => '1',
    SHOWING_AD_PHONE => '',
    SHOWING_AD_LOCATION_ID => '641780',
    SHOWING_AD_METRO_ID => '',
    SHOWING_AD_TITLE => '',
    SHOWING_AD_PRICE => ''
);

function print_options_of_cities($id) {
    foreach (CITIES as $key => $value) {
        echo '<option ', $id == $key ? 'selected=""' : '', 
                'data-coords=",," value="',$key,'">',$value,'</option>\n';
    }
}

function print_options_of_metro_stations($id) {    
    foreach (METRO_STATIONS as $key => $value) {
        echo '<option ', $id == $key ? 'selected=""' : '', 
                ' value="',$key,'">',$value,'</option>\n';
    }
}

function select_radio_private_person(&$ad) {
    $ad[SHOWING_AD_RADIO_COMPANY] = '';
    $ad[SHOWING_AD_RADIO_PRIVATE_PERSON] = 'checked=""';
}

function select_radio_company(&$ad) {
    $ad[SHOWING_AD_RADIO_COMPANY] = 'checked=""';
    $ad[SHOWING_AD_RADIO_PRIVATE_PERSON] = '';
}


function get_id_for_new_ad() {
    return 'key_'.time();
}

// ============= request_dispatcher (begin) =============

switch( filter_input(INPUT_SERVER,'REQUEST_METHOD') ) {
    case 'GET':  
        $action = filter_input(INPUT_GET, NAME_PARAM_ACTION);
        if( ACTION_REMOVE == $action ) {
            unset($_SESSION[filter_input(INPUT_GET, 'id')]);
        } 
        elseif ( ACTION_FILL_FORM == $action ) {
            $key_session = filter_input(INPUT_GET, 'id');
            if(isset($key_session)) {
                $ad = $_SESSION[$key_session];
                
                foreach ($ad as $key => $value) {
//                    if(array_key_exists($key, ARR_FORM_PARAMS) ) {
//                        $showing_ad[ ARR_FORM_PARAMS[$key] ] = $value;
//                    }
                    if(array_key_exists($key, $showing_ad) ) {
                        $showing_ad[ $key ] = $value;
                    }
                }
                
                switch( $ad[FORM_PARAMS_PRIVATE] ) {
                    case '1' : select_radio_company($showing_ad); break;
                    case '0' : select_radio_private_person($showing_ad); break;
                }
            }    
        }
        break;

    case 'POST': 
        if( ACTION_ADD == filter_input(INPUT_POST, NAME_PARAM_ACTION) ) {    
            $_SESSION[get_id_for_new_ad()] = $_POST;
        }
        break;
}

// ============= request_dispatcher (end) =============


include 'form_ad.php';


echo '<h3> Ваши объявления: </h3>';
echo '<table>';
echo '<tr><th>Название объявления</th><th>Цена</th><th>Имя продавца</th><th></th></tr>';

foreach ($_SESSION as $key => $value) {
    echo '<tr>';
    echo '<td><a href=lesson6-index.php?action=',ACTION_FILL_FORM,
            '&id=',$key,'>',$value[SHOWING_AD_TITLE],'</a></td>';
    echo '<td>',$value[SHOWING_AD_PRICE],'</td>';
    echo '<td>',$value[SHOWING_AD_SELLER_NAME],'</td>';
    echo '<td><a href=lesson6-index.php?action=',ACTION_REMOVE,
            '&id=',$key,'> Удалить </a></td>';
    echo '</tr>';
}

echo '</table>';

echo '</body></html>';