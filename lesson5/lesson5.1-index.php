<?php


include_once 'news.php';


function main_get($news) {
    $id = filter_input(INPUT_GET, param_id);
    
    show_news($news, $id, 'Метод GET');    
}

main_get($news);

/*
/GET
// Функция вывода всего списка новостей.

// Функция вывода конкретной новости.

// Точка входа.
// Если новость присутствует - вывести ее на сайте, иначе мы выводим весь список

// Был ли передан id новости в качестве параметра?
// если параметр не был передан - выводить 404 ошибку
// http://php.net/manual/ru/function.header.php
*/

