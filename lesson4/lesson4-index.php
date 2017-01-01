<?php

/* 
 * 
 * - Вам нужно вывести корзину для покупателя, где указать: 
 * 1) Перечень заказанных товаров, их цену, кол-во и остаток на складе
 * 2) В секции ИТОГО должно быть указано: сколько всего наименовний было заказано, каково общее количество товара, какова общая сумма заказа
 * - Вам нужно сделать секцию "Уведомления", где необходимо извещать покупателя о том, что нужного количества товара не оказалось на складе
 * - Вам нужно сделать секцию "Скидки", где известить покупателя о том, что если он заказал "игрушка детская велосипед" в количестве >=3 штук, то на эту позицию ему 
 * автоматически дается скидка 30% (соответственно цены в корзине пересчитываются тоже автоматически)
 * 3) у каждого товара есть автоматически генерируемый скидочный купон diskont, используйте переменную функцию, чтобы делать скидку на итоговую цену в корзине
 * diskont0 = скидок нет, diskont1 = 10%, diskont2 = 20%$ini_string='

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

const KEY_NAME = 'цена';
const KEY_PRICE = 'цена';
const KEY_QUANTITY = 'количество заказано';
const KEY_QUANTITY_IN_STORE = 'осталось на складе';
const KEY_DISCONT = 'diskont';


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
    define($COL_NAME_GOODS, 'Наименование');
    define($COL_NAME_QUANTITY, 'Кол-во');
    define($COL_NAME_QUANTITY_IN_STORE, 'Остаток');
    define($COL_NAME_PRICE, 'Цена');
    
    function p_th($text) {
        echo '<th>',$text,'</th>';
    }
    
    p_tr_b();
    p_th($COL_NAME_GOODS);
    p_th($COL_NAME_QUANTITY);
    p_th($COL_NAME_QUANTITY_IN_STORE);
    p_th($COL_NAME_PRICE);
    p_tr_e();
}


function print_table_last_line($total_price) {
    define($TOTAL, 'Итого');
    
    p_tr_b();
    p_td($TOTAL);
    echo '<td colspan=2></td>';
    p_td($total_price);
    p_tr_e();
}

function show_orders_table_view($orders, $total_price) {
    echo '<table>';
    
    print_table_head_line();
    
    array_walk($orders, 'print_one_table_line');
    
    print_table_last_line($total_price);
    
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



