<?php

/* 
 * 
 * - Вам нужно вывести корзину для покупателя, где указать: 
 * 1) Перечень заказанных товаров, их цену, кол-во и остаток на складе
 * 2) В секции ИТОГО должно быть указано: сколько всего наименовний было заказано, каково общее количество товара, какова общая сумма заказа
 * - Вам нужно сделать секцию "Уведомления", где необходимо извещать покупателя о том, что нужного количества товара не оказалось на складе
 * - Вам нужно сделать секцию "Скидки", где известить покупателя о том, что если он заказал "игрушка детская велосипед" в количестве >=3 штук, то на эту позицию ему 
 * автоматически дается скидка 30% (соответственно цены в корзине пересчитываются тоже автоматически)
 * 3) у каждого товара есть автоматически генерируемый скидочный купон diskont, 
 * используйте переменную функцию, чтобы делать скидку на итоговую цену в корзине
 * diskont0 = скидок нет, diskont1 = 10%, diskont2 = 20%

 */

$ini_string='
[игрушка мягкая мишка белый]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[одежда детская куртка синяя синтепон]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[игрушка детская велосипед]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';

';
$bd =  parse_ini_string($ini_string, true);
print_r($bd);


//a flag to show an order as a table view
const orders_view_table = 1;

//interface of params of any item of order
const KEY_NAME = 'name';
//define('KEY_NAME','name');
//$KEY_NAME = 'name';
const KEY_PRICE = 'цена';
const KEY_QUANTITY = 'количество заказано';
const KEY_QUANTITY_IN_STORE = 'осталось на складе';
const KEY_DISCONT = 'diskont';

//an array to storage special messages in the messages setction 
$messages_section = array();

//a string to storage discount messages
$discounts = array();

//В секции ИТОГО должно быть указано: сколько всего наименовний было заказано, 
//каково общее количество товара, какова общая сумма заказа
//an interface of the total info section
const KEY_TOTAL_COUNT_EXISTED_NAMES = 'count_existed_names';
const KEY_TOTAL_AMOUNT_OF_ITEMS = 'amount_of_items';
const KEY_TOTAL_PRICE_OF_ALL_ITEMS = 'price_of_all_items';


main_lesson4();

//--------------------------------------------------
//--------------------------------------------------

function main_lesson4() {
    global $bd;
    $order = $bd;

    convert_order($order);
    
    if(!checkup_order_on_quantity_in_store($order) ) {
        $order = array_map('update_order_and_messages_section', $order);
    }
    
    check_up_order_on_special_discounts($order);
    check_up_order_on_usual_discounts($order);
    
     //= array();
    $total_info = calc_total_info($order);
    
    show_orders($order, orders_view_table);
    show_section_total_info($total_info);
    
    if_is_existed_show_special_discounts_info();
    if_is_existed_show_usual_discounts_info();
}

//--------------------------------------------------
//--------------------------------------------------

//- Вам нужно сделать секцию "Уведомления", где необходимо извещать покупателя 
//о том, что нужного количества товара не оказалось на складе


function quantity_in_store_is_enough($item) {
    return ($item[KEY_QUANTITY_IN_STORE] >= $item[KEY_QUANTITY]);
}

//return TRUE if quantity is enough for all order
function checkup_order_on_quantity_in_store($order) {    
    function checkup_item_on_quantity_in_store($carry, $item) {
        if(!is_null($carry) && !$carry ) {
            return FALSE;
        }   
        return quantity_in_store_is_enough($item);
    }
    
    return array_reduce($order, 'checkup_item_on_quantity_in_store');
}


function form_new_message($item) {
    $msg = 'Товар "'.$item[KEY_NAME].'"';
    if( $item[KEY_QUANTITY_IN_STORE] == 0 ) {
        $msg .= ' не доступен и из Вашего заказа исключен';
    } else {
        $msg .= ' доступен только в кол-ве '.$item[KEY_QUANTITY_IN_STORE].' ед.';
        $msg .= ' Кол-во товара в заказе изменено с '.$item[KEY_QUANTITY]
                .' на '.$item[KEY_QUANTITY_IN_STORE].' ед.';
    }
    return $msg;
}

function create_new_message($item) {
    global $messages_section;  
    array_push($messages_section, form_new_message($item));
}

function update_order_and_messages_section($item) {
    if( quantity_in_store_is_enough($item) ) {
        return $item;        
    }
    
    create_new_message($item);
    $item[KEY_QUANTITY] = $item[KEY_QUANTITY_IN_STORE];
    
    return $item;
}



function convert_order(&$order) {
    function add_item_name_to_item_params($item_params,$item_name) {
        $item_params[KEY_NAME] = $item_name;
        return $item_params;
    }
    $order = array_map('add_item_name_to_item_params', $order, array_keys($order));
}



//--------------------------------------------------
//--------------------------------------------------

//- Вам нужно сделать секцию "Скидки", где известить покупателя о том, что если он заказал "игрушка детская велосипед" в количестве >=3 штук, то на эту позицию ему 
// автоматически дается скидка 30% (соответственно цены в корзине пересчитываются тоже автоматически)

function define_const_NAME_ONLY_ONE_DISCOUNT_ITEM() {
    if(!defined('NAME_ONLY_ONE_DISCOUNT_ITEM')) {
        define('NAME_ONLY_ONE_DISCOUNT_ITEM', 'игрушка детская велосипед');
    }
}

function checkup_item_on_special_discounts_is_existed($item) {    
    define_const_NAME_ONLY_ONE_DISCOUNT_ITEM();
    return ($item[KEY_NAME] == NAME_ONLY_ONE_DISCOUNT_ITEM && $item[KEY_QUANTITY] >= 3);
}

function update_price_of_special_discount_item(&$item) {
    $item[KEY_PRICE] *= 0.7;
}

function create_new_special_discounts_message_for_item($item) {
    global $discounts;
    $msg = 'Вы получили специальную скиду на товар "'.
            $item[KEY_NAME].'". Новая цена за единицу товара составит '.
            $item[KEY_PRICE];
    array_push($discounts, $msg);
}

function check_up_item_on_special_discounts($item) {
    if(checkup_item_on_special_discounts_is_existed($item) ) {
        update_price_of_special_discount_item($item);
        create_new_special_discounts_message_for_item($item);
    }
    return $item;
}

function check_up_order_on_special_discounts(&$order) {
    $order = array_map('check_up_item_on_special_discounts', $order);
}

//--------------------------------------------------
//--------------------------------------------------

//3) у каждого товара есть автоматически генерируемый скидочный купон diskont, 
// * используйте переменную функцию, чтобы делать скидку на итоговую цену в корзине
// * diskont0 = скидок нет, diskont1 = 10%, diskont2 = 20%

function calc_percent_value_diskont($item) {
    return substr($item[KEY_DISCONT], -1) * 10;
}

function checkup_item_on_usual_discounts_is_existed($item) {
    define_const_NAME_ONLY_ONE_DISCOUNT_ITEM();
    return !($item[KEY_NAME] == NAME_ONLY_ONE_DISCOUNT_ITEM);
}

function update_price_of_usual_discount_item(&$item) {
    $item[KEY_PRICE] *= (1 - calc_percent_value_diskont($item)/100);
}

function check_up_item_on_usual_discounts($item) {
    if(checkup_item_on_usual_discounts_is_existed($item) ) {
        update_price_of_usual_discount_item($item);
    }
    return $item;
}

function check_up_order_on_usual_discounts(&$order) {
    $order = array_map('check_up_item_on_usual_discounts', $order);
}

//--------------------------------------------------
//--------------------------------------------------

//В секции ИТОГО должно быть указано: сколько всего наименовний было заказано, 
//каково общее количество товара, какова общая сумма заказа

function calc_total_info($order) {
//    global $total_info;
    $total_info = array();
    
    $total_info[KEY_TOTAL_COUNT_EXISTED_NAMES] = get_count_existed_names($order);
    $total_info[KEY_TOTAL_AMOUNT_OF_ITEMS] = get_amount_of_items($order);
    $total_info[KEY_TOTAL_PRICE_OF_ALL_ITEMS] = get_price_of_all_items($order);
    
    return $total_info;
}

function get_count_existed_names($order) {
    function calc_count_existed_names($carry, $item) {
        return $carry += check_item_exist_in_order($item) ? 1 : 0;
    }
    return array_reduce($order, 'calc_count_existed_names',0);
}

function get_amount_of_items($order) {
    function calc_amount_of_items($carry, $item) {
        return $carry += $item[KEY_QUANTITY];
    }
    return array_reduce($order, 'calc_amount_of_items',0);
}

function get_price_of_all_items($order) {
    function calc_price_of_all_items($carry, $item) {
        return $carry += ($item[KEY_QUANTITY] > 0) ? $item[KEY_PRICE]*$item[KEY_QUANTITY] : 0;
    }
    return array_reduce($order, 'calc_price_of_all_items',0);
}

//--------------------------------------------------
//--------------------------------------------------


function check_item_exist_in_order($item_param) {
    return ($item_param[KEY_QUANTITY] > 0);
}

function p_tr_b() {
    echo '<tr>';
}

function p_tr_e() {
    echo '</tr>';
}

function p_td($text) {
    echo '<td>',$text,'</td>';
}

function print_one_table_line($item, $index) {
    if( check_item_exist_in_order($item) ) {
        p_tr_b();
        p_td($item[KEY_NAME]);
        p_td($item[KEY_QUANTITY]);
        p_td($item[KEY_QUANTITY_IN_STORE]);
        p_td($item[KEY_PRICE]);
        p_td($item[KEY_PRICE]*$item[KEY_QUANTITY]);
        p_tr_e();
    }
}

function print_table_head_line() {
    //1) Перечень заказанных товаров, их цену, кол-во и остаток на складе
    if(!defined('COL_NAME_QUANTITY')) {
        define('COL_NAME_GOODS', 'Наименование');
    }
    if(!defined('COL_NAME_QUANTITY')) {
        define('COL_NAME_QUANTITY', 'Кол-во');
    }
    if(!defined('COL_NAME_QUANTITY_IN_STORE')) {
        define('COL_NAME_QUANTITY_IN_STORE', 'Остаток');
    }
    if(!defined('COL_NAME_PRICE')) {
        define('COL_NAME_PRICE', 'Цена за шт.');
    }
    if(!defined('COL_NAME_TOTAL_PRICE')) {
        define('COL_NAME_TOTAL_PRICE', 'Всего за товар');
    }
    
    function p_th($text) {
        echo '<th>',$text,'</th>';
    }
    
    p_tr_b();
    p_th(COL_NAME_GOODS);
    p_th(COL_NAME_QUANTITY);
    p_th(COL_NAME_QUANTITY_IN_STORE);
    p_th(COL_NAME_PRICE);
    p_th(COL_NAME_TOTAL_PRICE);
    p_tr_e();
}


function show_orders_table_view($orders) {
    echo '<table>';    
    print_table_head_line();    
    array_walk($orders, 'print_one_table_line');    
    echo '</table>';
}

//------------------------------------------------------------------------
//------------------------------------------------------------------------

function show_orders($orders, $orders_view) {
    echo '<br/>';
    echo '<h3>Ваш заказ</h3>';
    
    switch ($orders_view) {
        case orders_view_table:
            show_orders_table_view($orders);
            break;

        default:
            echo 'View error!!<br/>';
            break;
    }
}

function show_usual_title($title) {
    echo '<h3>',$title,'</h3>';
}

//------------------------------------------------------------------------
//------------------------------------------------------------------------

function show_section_total_info($total_info) {
    show_usual_title('Итого:');
    echo 'Всего наименовний заказано: ',$total_info[KEY_TOTAL_COUNT_EXISTED_NAMES],'<br/>';
    echo 'Общее количество товара: ',$total_info[KEY_TOTAL_AMOUNT_OF_ITEMS],'<br/>';
    echo 'Общая сумма заказа: ',$total_info[KEY_TOTAL_PRICE_OF_ALL_ITEMS],'<br/>';
}

function if_is_existed_show_special_discounts_info() {
    function show_special_discounts($item, $index) {
        echo $item,'<br/>';
    }

    global $messages_section;
    if(count($messages_section) > 0) {
        show_usual_title('Обратите внимания:');
        array_walk($messages_section, 'show_special_discounts');
    }
}

function if_is_existed_show_usual_discounts_info() {
    
    function show_usual_discounts($item, $index) {
        echo $item,'<br/>';
    }

    global $discounts;
    if(count($discounts) > 0) {
        show_usual_title('Ваши скидки:');
        array_walk($discounts, 'show_usual_discounts');
    }
}