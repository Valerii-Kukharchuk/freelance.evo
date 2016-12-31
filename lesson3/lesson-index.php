<?php

/* 
 Задание 1
 * - Создайте массив $date с пятью элементами
 * - C помощью генератора случайных чисел забейте массив $date юниксовыми метками
 * - Сделайте вывод сообщения на экран о том, какой день в сгенерированном массиве получился наименьшим, а какой месяц наибольшим
 * - Отсортируйте массив по возрастанию дат
 * - С помощью функция для работы с массивами извлеките последний элемент массива в новую переменную $selected
 * - C помощью функции date() выведите $selected на экран в формате "дд.мм.ГГ ЧЧ:ММ:СС"
 * - Выставьте часовой пояс для Нью-Йорка, и сделайте вывод снова, чтобы проверить, что часовой пояс был изменен успешно
 * 
 */

//Создайте массив $date с пятью элементами
$date = array(1,2,3,4,5);

//- C помощью генератора случайных чисел забейте массив $date юниксовыми метками

function rand_timestamp($value) {
    $max_int = 2147483647;
    return rand(0, $max_int);
}

$date = array_map('rand_timestamp', $date);

//var_dump($date);

//Сделайте вывод сообщения на экран о том, какой день в сгенерированном массиве 
//получился наименьшим, а какой месяц наибольшим

date_default_timezone_set('UTC');

function get_num_day_by_timestamp($timestamp) {
    return localtime($timestamp,TRUE)['tm_mday'];
}

function get_num_day_by_index(array $values, $index) {
    return get_num_day_by_timestamp($values[$index]);
}

function print_day_number($value,$index) {
    echo '['.$index.'] day_number = '.get_num_day_by_timestamp($value).'<br/>';
}

array_walk($date, 'print_day_number');

function find_min_day_number($carry, $item) {
    return min(get_num_day_by_timestamp($item),$carry);
}

$min_day_number = array_reduce($date, 
        'find_min_day_number',get_num_day_by_index($date,0));
echo 'min_day_number = '.$min_day_number.'<br/>';

//var_dump($date);

