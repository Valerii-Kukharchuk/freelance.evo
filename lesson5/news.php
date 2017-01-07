<?php

$news='Четыре новосибирские компании вошли в сотню лучших работодателей
Выставка университетов США: открой новые горизонты
Оценку «неудовлетворительно» по качеству получает каждая 5-я квартира в новостройке
Студент-изобретатель раскрыл запутанное преступление
Хоккей: «Сибирь» выстояла против «Ак Барса» в пятом матче плей-офф
Здоровое питание: вегетарианская кулинария
День святого Патрика: угощения, пивной теннис и уличные гуляния с огнем
«Красный факел» пустит публику на ночные экскурсии за кулисы и по закоулкам столетнего здания
Звезды телешоу «Голос» Наргиз Закирова и Гела Гуралиа споют в «Маяковском»';

$news = explode("\n", $news);

define('COUNT_NEWS',count($news));

const param_id = 'id';

function show_news($news, $id) {
    
    function checkup_valid_id($news, $id) {
        return array_key_exists($id,$news);
    }
   
    if( is_null($id) ) {
        header("HTTP/1.0 404 Not found");
        echo 'Parametr "id" required in an URL! <br/>';
        echo 'Correct using: <br/>';
        echo ' ...?id={0..',COUNT_NEWS,'} -- get news by its "id". ','<br/>';
        echo ' ...?id={!(0..',COUNT_NEWS,')} -- get whole list of news';
        exit();
    } 
    
    if( checkup_valid_id($news, $id) ) {
        echo '<h3>Новость [',$id,']:</h3>';
        echo $news[$id],'<br/>';
    } else {      
        echo '<h3>Все новости:</h3>';
        foreach ($news as $value) {
            echo $value,'<br/>';
        }
    }
}