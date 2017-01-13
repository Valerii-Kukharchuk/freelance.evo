<?php

session_start();

//--- names of available actions with form_add
const NAME_PARAM_ACTION = 'action';
const ACTION_ADD = 'add';
const ACTION_REMOVE = 'remove';
const ACTION_FILL_FORM = 'fill_form';

// const CITIES = array(
if( !defined('CITIES') ) {
    define('CITIES', serialize ( array (
// $CITIES = array (
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
    // );
    
    )) );
}

// const METRO_STATIONS = array(
if( !defined('METRO_STATIONS') ) {
    define('METRO_STATIONS', serialize( array (
// $METRO_STATIONS = array (
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
        // );
    )));
}

//categor'es names
const CATEGORY_TRANSPORT = 'transport';
const CATEGORY_REAL_ESTATE = 'real_estate';
const CATEGORY_JOB = 'job';
const CATEGORY_SERVICIES = 'servicies';
const CATEGORY_PERSONALIA = 'personalia';
const CATEGORY_FOR_HOME = 'for_home';
const CATEGORY_CONSUMER_ELECTRONICS = 'consumer_electronics';
const CATEGORY_HOBBY = 'hobby';
const CATEGORY_ANIMALS = 'animals';

//arrays of category's options
if( !defined('CATEGORIES') ) {
    define('CATEGORIES', serialize( array(    
// $CATEGORIES = array(    
        CATEGORY_TRANSPORT => array(
            "9"   => 'Автомобили с пробегом',
            "109" => 'Новые автомобили',
            "14"  => 'Мотоциклы и мототехника',
            "81"  => 'Грузовики и спецтехника',
            "11"  => 'Водный транспорт',
            "10"  => 'Запчасти и аксессуары',
        ),
        CATEGORY_REAL_ESTATE => array(
            "24" => 'Квартиры',
            "23" => 'Комнаты',
            "25" => 'Дома, дачи, коттеджи',
            "26" => 'Земельные участки',
            "85" => 'Гаражи и машиноместа',
            "42" => 'Коммерческая недвижимость',
            "86" => 'Недвижимость за рубежом'
        ),
        CATEGORY_JOB => array(
            "111" => 'Вакансии (поиск сотрудников)',
            "112" => 'Резюме (поиск работы)'
        ),
        CATEGORY_SERVICIES => array(
            "114" => 'Предложения услуг',
            "115" => 'Запросы на услуги'
        ),
        CATEGORY_PERSONALIA => array(
            "27" => 'Одежда, обувь, аксессуары',
            "29" => 'Детская одежда и обувь',
            "30" => 'Товары для детей и игрушки',
            "28" => 'Часы и украшения',
            "88" => 'Красота и здоровье'
        ),
        CATEGORY_FOR_HOME => array(
            "21" => 'Бытовая техника',
            "20" => 'Мебель и интерьер',
            "87" => 'Посуда и товары для кухни',
            "82" => 'Продукты питания',
            "19" => 'Ремонт и строительство',
            "106" => 'Растения'
        ),
        CATEGORY_CONSUMER_ELECTRONICS => array(
            "32"  => 'Аудио и видео',
            "97"  => 'Игры, приставки и программы',
            "31"  => 'Настольные компьютеры',
            "98"  => 'Ноутбуки',
            "99"  => 'Оргтехника и расходники',
            "96"  => 'Планшеты и электронные книги',
            "84"  => 'Телефоны',
            "101" => 'Товары для компьютера',
            "105" => 'Фототехника'
        ),
        CATEGORY_HOBBY => array(
            "33"  => 'Билеты и путешествия',
            "34"  => 'Велосипеды',
            "83"  => 'Книги и журналы',
            "36"  => 'Коллекционирование',
            "38"  => 'Музыкальные инструменты',
            "102" => 'Охота и рыбалка',
            "39"  => 'Спорт и отдых',
            "103" => 'Знакомства'
        ),
        CATEGORY_ANIMALS => array(
            "89" => 'Собаки',
            "90" => 'Кошки',
            "91" => 'Птицы',
            "92" => 'Аквариум',
            "93" => 'Другие животные',
            "94" => 'Товары для животных'
        ),
        CATEGORY_BUSINESS => array(
            "116" => 'Готовый бизнес',
            "40"  => 'Оборудование для бизнеса'
        )
        // );
    )));
}


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
const SHOWING_AD_CATEGORY_ID = 'category_id';
const SHOWING_AD_DESCRIPTION = 'description';


const FORM_PARAMS_PRIVATE = 'private';


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
    SHOWING_AD_PRICE => '0',
    SHOWING_AD_CATEGORY_ID => '',
    SHOWING_AD_DESCRIPTION => ''
);


function print_any_options($options, $selected_id, $attr) {
    foreach ($options as $key => $value) {
        echo '<option ', $selected_id == $key ? 'selected="" ' : ' ', 
                $attr,'" value="',$key,'">',$value,'</option>\n';
    }
}

function print_options_of_cities($id) {
    $arr = unserialize(CITIES); 
    print_any_options($arr, $id, 'data-coords=",,"');
}

function print_options_of_metro_stations($id) {    
    $arr = unserialize(METRO_STATIONS);
    print_any_options($arr, $id, '');
}

function print_options_of_category($category, $id) {
    $arr = unserialize(CATEGORIES);
    print_any_options($arr[$category], $id, '');
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
                    if(array_key_exists($key, $showing_ad) ) {
                        $showing_ad[ $key ] = $value;
                    }
                }
                
                
                if( $ad[SHOWING_AD_ALLOW_MAILS] == 1 ) {
                    $showing_ad[SHOWING_AD_ALLOW_MAILS] = 'checked';
                } else {
                    $showing_ad[SHOWING_AD_ALLOW_MAILS] = '';
                }
                
                switch( $ad[FORM_PARAMS_PRIVATE] ) {
                    case '1' : 
                        $showing_ad[SHOWING_AD_RADIO_COMPANY] = 'checked=""';
                        $showing_ad[SHOWING_AD_RADIO_PRIVATE_PERSON] = '';
                        break;
                    case '0' : 
                        $showing_ad[SHOWING_AD_RADIO_COMPANY] = '';
                        $showing_ad[SHOWING_AD_RADIO_PRIVATE_PERSON] = 'checked=""';
                        break;
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