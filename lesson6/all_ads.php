<?php

//include_once 'utils.php';

session_start();

const AD_PARAM_TITLE = 'title';
const AD_PARAM_PRICE = 'price';
const AD_PARAM_SELLER_NAME = 'seller_name';

function show_all_ads() {
    echo '<h3> Ваши объявления: </h3>';

    echo '<table>';
    
    echo '<tr><th>Название объявления</th><th>Цена</th><th>Имя продавца</th><th></th></tr>';

    foreach ($_SESSION as $key => $value) {
        echo '<tr>';
//        echo '<td>',$value[AD_PARAM_TITLE],'</td>';
//        echo '<td><a href=fill_ad_gaps.php?id=',$key,'>',$value[AD_PARAM_TITLE],'</a></td>';
        echo '<td><a href=show_form_ad.php?id=',$key,'>',$value[AD_PARAM_TITLE],'</a></td>';
        echo '<td>',$value[AD_PARAM_PRICE],'</td>';
        echo '<td>',$value[AD_PARAM_SELLER_NAME],'</td>';
        echo '<td><a href=del_ad.php?id=',$key,'> Удалить </a></td>';
        echo '</tr>';
    }
    
    echo '</table>';
}
