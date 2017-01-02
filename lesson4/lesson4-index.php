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
//print_r($bd);

function main_lesson4() {
    global $bd;
    $order = $bd;
    
    convert_order($order);
    
    if(!checkup_order_on_quantity_in_store($order) ) {
        array_map(update_order_and_messages_section, $order);
    }
    
    check_up_order_on_special_discounts($order);
    
    check_up_order_on_usual_discounts($order);
    
    show_orders($order, orders_view_table);
}

//--------------------------------------------------
//--------------------------------------------------

//interface of params of any item of order
const KEY_NAME = 'name';
const KEY_PRICE = 'цена';
const KEY_QUANTITY = 'количество заказано';
const KEY_QUANTITY_IN_STORE = 'осталось на складе';
const KEY_DISCONT = 'diskont';

//--------------------------------------------------
//--------------------------------------------------

//- Вам нужно сделать секцию "Уведомления", где необходимо извещать покупателя 
//о том, что нужного количества товара не оказалось на складе

$messages_section = array();


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
    
    return array_reduce($order, checkup_item_on_quantity_in_store);
}

function form_new_messaged($item) {
    $msg = 'Товар \"'.$item[KEY_NAME].'\"';
    if( $item[KEY_QUANTITY_IN_STORE] == 0 ) {
        $msg .= ' не доступен и из Вашего заказа исключен';
    } else {
        $msg .= ' доступен только в кол-ве '.$item[KEY_QUANTITY_IN_STORE].' ед.';
        $msg .= ' Кол-во товара в заказе изменено с '.$item[KEY_QUANTITY]
                .' на '.$item[KEY_QUANTITY_IN_STORE].' ед.';
    }
    return msg;
}

function create_new_message($item) {
    global $messages_section;  
    array_push($messages_section, form_new_messaged($item));
}

function update_order_and_messages_section($item) {
    if( quantity_in_store_is_enough($item) ) {
        return $item;        
    }
    
    create_new_message($item[KEY_QUANTITY],$item[KEY_QUANTITY_IN_STORE]);
    $item[KEY_QUANTITY] = $item[KEY_QUANTITY_IN_STORE];
    
    return $item;
}

function convert_order($order) {    
    function add_item_name_to_item_params($item_params,$item_name) {
        $item_params[KEY_NAME] = $item_name;
    }    
    array_map(add_item_name_to_item_params, $order, array_keys($order));
}



//--------------------------------------------------
//--------------------------------------------------

//- Вам нужно сделать секцию "Скидки", где известить покупателя о том, что если он заказал "игрушка детская велосипед" в количестве >=3 штук, то на эту позицию ему 
// автоматически дается скидка 30% (соответственно цены в корзине пересчитываются тоже автоматически)

$discounts = '';


function checkup_item_on_SPECIAL_discounts_is_existed($item) {
    define(NAME_ONLY_ONE_DISCOUNT_ITEM, 'игрушка детская велосипед');
    return ($item[KEY_NAME] == NAME_ONLY_ONE_DISCOUNT_ITEM && $item[KEY_QUANTITY] >= 3);
}

function update_price_of_special_discount_item(&$item) {
    $item[KEY_PRICE] *= 0.7;
}

function create_new_special_discounts_message_for_item($item) {
    global $discounts;
    $discounts .= 'Вы получили специальную скиду на товар \"'.
            $item[KEY_NAME].'\". Новая цена за единицу товара составит '.
            $item[KEY_PRICE];
}

function check_up_item_on_special_discounts($item) {
    if(checkup_item_on_special_discounts_is_existed($item) ) {
        update_price_of_special_discount_item($item);
        create_new_special_discounts_message_for_item($item);
    }
    return $item;
}

function check_up_order_on_special_discounts($order) {
    array_map(check_up_item_on_special_discounts, $order);
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
    define(NAME_ONLY_ONE_DISCOUNT_ITEM, 'игрушка детская велосипед');
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

function check_up_order_on_usual_discounts($order) {
    array_map(check_up_item_on_usual_discounts, $order);
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
        p_tr_e();
    }
}


function print_table_head_line() {
    //1) Перечень заказанных товаров, их цену, кол-во и остаток на складе
    define(COL_NAME_GOODS, 'Наименование');
    define(COL_NAME_QUANTITY, 'Кол-во');
    define(COL_NAME_QUANTITY_IN_STORE, 'Остаток');
    define(COL_NAME_PRICE, 'Цена');
    
    function p_th($text) {
        echo '<th>',$text,'</th>';
    }
    
    p_tr_b();
    p_th(COL_NAME_GOODS);
    p_th(COL_NAME_QUANTITY);
    p_th(COL_NAME_QUANTITY_IN_STORE);
    p_th(COL_NAME_PRICE);
    p_tr_e();
}


function print_table_last_line($total) {
    define($TOTAL, 'Итого');
    
    p_tr_b();
    p_td($TOTAL);
    echo '<td colspan=2></td>';
    p_td($total);
    p_tr_e();
}

function show_orders_table_view($orders, $total_info) {
    echo '<table>';
    
    print_table_head_line();
    
    array_walk($orders, 'print_one_table_line');
    
    print_table_last_line($total_info);
    
    echo '</table>';
}

//------------------------------------------------------------------------
//------------------------------------------------------------------------
const orders_view_table = 1;
function show_orders($orders, $orders_view) {
    switch ($orders_view) {
        case orders_view_table:
            show_orders_table_view($orders);
            break;

        default:
            echo 'View error!!<br/>';
            break;
    }
}



