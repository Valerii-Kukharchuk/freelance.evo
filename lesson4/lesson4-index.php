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

const PERCENT_OF_SPECIAL_DISCOUNT = 30;

//interface of params of any item of order
const KEY_NAME = 'name';
//define('KEY_NAME','name');
//$KEY_NAME = 'name';
const KEY_PRICE = 'цена';
const KEY_OLD_PRICE = 'old_цена';
const KEY_PREV_QUANTITY = 'prev_quantity';
const KEY_QUANTITY = 'количество заказано';
const KEY_QUANTITY_IN_STORE = 'осталось на складе';
const KEY_DISCONT = 'diskont';
const KEY_ITEM_DISCONT = 'item.diskont';
const KEY_DESCRIPTION = 'description';


//В секции ИТОГО должно быть указано: сколько всего наименовний было заказано, 
//каково общее количество товара, какова общая сумма заказа
//an interface of the total info section
const KEY_TOTAL_COUNT_EXISTED_NAMES = 'count_existed_names';
const KEY_TOTAL_AMOUNT_OF_ITEMS = 'amount_of_items';
const KEY_TOTAL_PRICE_OF_ALL_ITEMS = 'price_of_all_items';



//--------------------------------------------------
//--------------------------------------------------

function main_lesson4($bd) {

    //an array to storage special messages in the messages setction 
    $messages_section = array();
    //a string to storage discount messages
    $discounts = array();
    
    $order = $bd;
    
    init_all_defines();

    convert_order($order);
    
    if_not_enough_quantity_in_store_update_order_and_messages_section($order, $messages_section);
    if_is_existed_special_discounts_update_order_and_discount_section($order,$discounts);
    
    $order = array_map('check_up_item_on_usual_discounts', $order);
    
    $total_info = calc_total_info($order);
    
    echo '<br/>';
    show_orders($order, orders_view_table);
    show_section_total_info($total_info);
    
    if_is_existed_show_special_discounts_info($messages_section);
    if_is_existed_show_usual_discounts_info($discounts);
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

function if_not_enough_quantity_in_store_update_order_and_messages_section(&$order,&$messages_section) {
    $count_order = count($order);
    for ($index = 0; $index < $count_order; $index++) {
        $item = $order[$index];
        if( quantity_in_store_is_enough($item) ) {
            continue;
        }
             
        $msg_for_description = '';
        $msg = 'Товар "'.$item[KEY_NAME].'"';
        if( $item[KEY_QUANTITY_IN_STORE] == 0 ) {
            $msg .= ' не доступен и из Вашего заказа исключен';
        } else {
            $msg_for_description = ' доступен только в кол-ве '
                    .$item[KEY_QUANTITY_IN_STORE].' ед.'
                    .' Кол-во товара в заказе изменено с '.$item[KEY_QUANTITY]
                    .' на '.$item[KEY_QUANTITY_IN_STORE].' ед.';
            $msg .= $msg_for_description;
        }
        $messages_section[] = $msg;

        $item[KEY_DESCRIPTION] = $msg_for_description;
        $item[KEY_QUANTITY] = $item[KEY_QUANTITY_IN_STORE];
        
        $order[$index] = $item;
    }
}        

function update_order_and_messages_section($item) {
    global $messages_section;
    
    if( quantity_in_store_is_enough($item) ) {
        return $item;        
    }
    
    
   
    return $item;
}



function convert_order(&$order) {
    function add_item_name_to_item_params($item_params,$item_name) {
        $item_params[KEY_NAME] = $item_name;
        $item_params[KEY_OLD_PRICE] = $item_params[KEY_PRICE];
        $item_params[KEY_DESCRIPTION] = '-';
        $item_params[KEY_PREV_QUANTITY] = $item_params[KEY_QUANTITY];
        $item_params[KEY_ITEM_DISCONT] = 0;
        return $item_params;
    }
    $order = array_map('add_item_name_to_item_params', $order, array_keys($order));
}


//--------------------------------------------------
//--------------------------------------------------

//- Вам нужно сделать секцию "Скидки", где известить покупателя о том, что если он заказал "игрушка детская велосипед" в количестве >=3 штук, то на эту позицию ему 
// автоматически дается скидка 30% (соответственно цены в корзине пересчитываются тоже автоматически)

function if_is_existed_special_discounts_update_order_and_discount_section(&$order,&$discounts) {
    $count_items = count($order);
    for ($index = 0; $index < $count_items; $index++) {
        $item = $order[$index];
        
        if( $item[KEY_NAME] == NAME_ONLY_ONE_DISCOUNT_ITEM 
        && $item[KEY_QUANTITY] >= 3 ) 
        {
            $item[KEY_PRICE] *= (1 - PERCENT_OF_SPECIAL_DISCOUNT/100);

            $discounts[] = 'Вы получили специальную скиду на товар "'.
                $item[KEY_NAME].'". Новая цена за единицу товара составит '.
                $item[KEY_PRICE];

            $item[KEY_ITEM_DISCONT] = PERCENT_OF_SPECIAL_DISCOUNT;
        }
        
        $order[$index] = $item;
    }
    
}

//--------------------------------------------------
//--------------------------------------------------

//3) у каждого товара есть автоматически генерируемый скидочный купон diskont, 
// * используйте переменную функцию, чтобы делать скидку на итоговую цену в корзине
// * diskont0 = скидок нет, diskont1 = 10%, diskont2 = 20%

function calc_percent_value_diskont($item) {
    return substr($item[KEY_DISCONT], -1) * 10;
}

function check_up_item_on_usual_discounts($item) {
    if(!($item[KEY_NAME] == NAME_ONLY_ONE_DISCOUNT_ITEM) ) {
        $diskont = calc_percent_value_diskont($item);
        $item[KEY_PRICE] *= (1 - $diskont/100);
        $item[KEY_ITEM_DISCONT] = $diskont;
    }
    return $item;
}

//--------------------------------------------------
//--------------------------------------------------

//В секции ИТОГО должно быть указано: сколько всего наименовний было заказано, 
//каково общее количество товара, какова общая сумма заказа

function calc_total_info($order) {
    $total_info = array();
    
    $total_info[KEY_TOTAL_COUNT_EXISTED_NAMES] = get_count_existed_names($order);
    $total_info[KEY_TOTAL_AMOUNT_OF_ITEMS] = get_amount_of_items($order);
    $total_info[KEY_TOTAL_PRICE_OF_ALL_ITEMS] = get_price_of_all_items($order);
    
    return $total_info;
}

function get_count_existed_names($order) {    
    return 
        calc_sum($order, function ($item) {
            return check_item_exist_in_order($item) ? 1 : 0;
        });
}

function get_amount_of_items($order) {
    return 
        calc_sum($order, function ($item) {
            return $item[KEY_QUANTITY];
        });
}

function get_price_of_all_items($order) {
    return 
        calc_sum($order, function ($item) {
            return ($item[KEY_QUANTITY] > 0) ? $item[KEY_PRICE]*$item[KEY_QUANTITY] : 0;
        });
}

function calc_sum($array, callable $get_additional) {
    $sum = 0;
    foreach ($array as $item) {
        $sum += call_user_func($get_additional,$item);
    }
    return $sum;
}
//--------------------------------------------------
//--------------------------------------------------


function check_item_exist_in_order($item_param) {
    return ($item_param[KEY_QUANTITY] > 0);
}

function print_one_table_line($item) {
    if( check_item_exist_in_order($item) ) {
        echo '<tr>';
        echo '<td>',$item[KEY_NAME],'</td>';
        
        if($item[KEY_PREV_QUANTITY] != $item[KEY_QUANTITY]) {
            $quantity_string = $item[KEY_PREV_QUANTITY].' => '.$item[KEY_QUANTITY];
        } 
        else {
            $quantity_string = $item[KEY_QUANTITY];
        }      
        echo '<td>',$quantity_string,'</td>';        
        echo '<td>',$item[KEY_QUANTITY_IN_STORE],'</td>';        
        echo '<td>',$item[KEY_OLD_PRICE],'</td>';
        
        $discount = $item[KEY_ITEM_DISCONT];
        echo '<td>', ( $discount > 0) ? $discount.'%' : '-' ,'</td>';
        
        echo '<td>',$item[KEY_PRICE],'</td>';
        echo '<td>',$item[KEY_PRICE]*$item[KEY_QUANTITY],'</td>';
              
        echo '<td>',$item[KEY_DESCRIPTION],'</td>';
        echo '</tr>';
    }
}

function init_all_defines() {
    if(!defined('COL_NAME_QUANTITY')) {
        define('COL_NAME_GOODS', 'Наименование');
    }
    if(!defined('COL_NAME_QUANTITY')) {
        define('COL_NAME_QUANTITY', 'Количество');
    }
    if(!defined('COL_NAME_QUANTITY_IN_STORE')) {
        define('COL_NAME_QUANTITY_IN_STORE', 'Остаток');
    }
    if(!defined('COL_NAME_OLD_PRICE')) {
        define('COL_NAME_OLD_PRICE', 'Цена за шт.');
    }
    if(!defined('COL_NAME_DISCOUNT')) {
        define('COL_NAME_DISCOUNT', 'Скидка');
    }
    if(!defined('COL_NAME_PRICE')) {
        define('COL_NAME_PRICE', 'Цена со скидкой за шт.');
    }
    if(!defined('COL_NAME_TOTAL_PRICE')) {
        define('COL_NAME_TOTAL_PRICE', 'Всего за товар');
    }
    if(!defined('COL_NAME_DESCRIPTION')) {
        define('COL_NAME_DESCRIPTION', 'Примечание');
    }
    if(!defined('NAME_ONLY_ONE_DISCOUNT_ITEM')) {
        define('NAME_ONLY_ONE_DISCOUNT_ITEM', 'игрушка детская велосипед');
    }
}

function print_table_head_line() {
    //1) Перечень заказанных товаров, их цену, кол-во и остаток на складе
    echo '<tr>';
    echo '<th>',COL_NAME_GOODS,'</th>';
    echo '<th>',COL_NAME_QUANTITY,'</th>';
    echo '<th>',COL_NAME_QUANTITY_IN_STORE,'</th>';
    echo '<th>',COL_NAME_OLD_PRICE,'</th>';
    echo '<th>',COL_NAME_DISCOUNT,'</th>';
    echo '<th>',COL_NAME_PRICE,'</th>';
    echo '<th>',COL_NAME_TOTAL_PRICE,'</th>';
    echo '<th>',COL_NAME_DESCRIPTION,'</th>';
    echo '</tr>';
}


function show_orders_table_view($order) {
    echo '<table border=1>';    
    print_table_head_line();    
    array_walk($order, 'print_one_table_line');    
    echo '</table>';
}

//------------------------------------------------------------------------
//------------------------------------------------------------------------

function show_orders($orders, $orders_view) {
    show_usual_title('Ваш заказ');
    
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

function if_is_existed_show_special_discounts_info($messages_section) {
    if(count($messages_section) > 0) {
        show_usual_title('Обратите внимания:');
        foreach ($messages_section as $value) {
            echo $value,'<br/>';
        }
    }
}

function if_is_existed_show_usual_discounts_info($discounts) {
    if(count($discounts) > 0) {
        show_usual_title('Ваши скидки:');
        foreach ($discounts as $value) {
            echo $value,'<br/>';
        }
    }
}

main_lesson4($bd);