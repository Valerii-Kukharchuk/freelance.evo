<?php

include_once 'news.php';


function show_input_form() {
    $s =  '<form method="POST" action="lesson5.2-index.php">';
    $s .= '<input type="text" name="id" placeholder="введите id новости"/>';
    $s .= '<input type="submit">';
    $s .= '<form/>';
    echo $s;
}


function main_post($news) {    
    $id = filter_input(INPUT_POST, param_id);
    
    echo '<h3>Метод POST</h3>';
    
    show_input_form();
    
    echo '<br/>';
    
    show_news($news, $id);
}

main_post($news);


