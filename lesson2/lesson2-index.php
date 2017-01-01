<?php
/*
 *  * Задание 1
 * - Создайте переменную $name и присвойте ей значение содержащее ваше имя, например Игорь
 * - Создайте переменную $age и присвойте ей ваше количество лет, например 30
 * - Выведите на экран фразу по шаблону "Меня зовут Игорь"
 *                                      "Мне 30 лет"
 * Удалите переменные $name и $age
 */

$name = 'Валерий';
$age = 32;

echo 'Меня зовут ',$name,'<br/>';
echo 'Мне ',$age,' лет';

unset($name, $age);
//----------------- task_1 (end) -------------------

/* 
 * Задание 2
 * - Создайте константу и присвойте ей значение города в котором живете
 * - Прежде чем выводить константу на экран, проверьте, действительно ли она объявлена и существует
 * - Выведите значение объявленной константы
 * - Попытайтесь изменить значение созданной константы
 */

echo '<br/>';

const CITY = 'Kharkov';

if(defined('CITY')) {
    echo CITY;
}
//CITY = 'bla'; // invalid. error of compile time

//define(CITY,'Kharkov');
//
//if(defined('CITY')) {
//    echo CITY;
//}
//'CITY' = 'la';// invalid. runtime error. Parse error: parse error in ../freelance.evo/lesson2/lesson-index.php on line 42

//----------------- task_2 (end) -------------------

echo '<br/>';
/*
 * Задание 3
 * - Создайте ассоциативный массив $book, ключами которого будут являться значения 
 * "title", "author", "pages"
 * - Заполните его по логике описания книг, укажите значения книги, которую недавно прочитали
 * - Выведите следующую строку на экран, следуя шаблону: "Недавно я прочитал книгу 'title', 
 * написанную автором author, я осилил все pages страниц, мне она очень понравилась"
 *  
 */

const TITLE = 'title';
const AUTHOR = 'author';
const PAGES = 'pages';

$last_book_title = 'Инферно';
$last_book_author = 'Дэн Браун';
$last_book_pages = 544;

$book = array(TITLE => $last_book_title, AUTHOR => $last_book_author,
        PAGES => $last_book_pages);

$printed_string = 'Недавно я прочитал книгу '.$book[TITLE].', 
  написанную автором '.$book[AUTHOR].', я осилил все '.
        $book[PAGES].' страниц, мне она очень понравилась';
echo $printed_string;

//------------- task_3 (end) -----------------

echo '<br/>';
/*
Задание 4
 *  - Создайте индексный массив $books, который будет содержать в себе два 
 * массива $book1 и $book2, где будут записаны уже две последние прочитанные вами книги
 *  - Выведите следующую строку на экран, следуя шаблону: "Недавно я прочитал 
 * книги 'title1' и 'title2', 
 *  написанные соответственно авторами author1 и author2, 
 * я осилил в сумме pages1+pages2 страниц, не ожидал от себя подобного"
 *  */

$book1 = $book;
$book2 = array(TITLE => 'Игра престолов. Битва королей', 
        AUTHOR => 'Мартин Джордж Р.Р.',
        PAGES => 1152);

$books = array($book1,$book2);

$printed_string = 'Недавно я прочитал книги ';
$printed_string .= $books[0][TITLE].' и '.$books[1][TITLE];
$printed_string .= ', написанные соответственно авторами ';
$printed_string .= $books[0][AUTHOR].' и '.$books[1][AUTHOR];
$printed_string .= ', я осилил в сумме '.($books[0][PAGES]+$books[1][PAGES]);
$printed_string .= ' страниц, не ожидал от себя подобного';
echo $printed_string;