
<!DOCTYPE html>
<html>
    <head>
        <title>Ad form</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
      
        <form action="lesson6-index.php?action=add" method="post">
            <input type="hidden" name="action" value="add">
            <div class="form-row-indented">
                <label class="form-label-radio">
                    <input id="id_radio_private_person" type="radio" 
                           <?php echo $showing_ad[SHOWING_AD_RADIO_PRIVATE_PERSON]; ?> value="1" name="private">Частное лицо</label>
                <label class="form-label-radio">
                    <input id="id_radio_company" type="radio" 
                           <?php echo $showing_ad[SHOWING_AD_RADIO_COMPANY]; ?> value="0" name="private">Компания</label> 
            </div>
            
            <div class="form-row"> 
                <label for="fld_seller_name" class="form-label"><b id="your-name">Ваше имя</b></label>
                <input type="text" maxlength="40" class="form-input-text" 
                       value=<?php echo '"',$showing_ad[SHOWING_AD_SELLER_NAME],'"';?>
                       name="seller_name" id="fld_seller_name">
            </div>
            
            <div style="display: none;" id="your-manager" class="form-row"> 
                <label for="fld_manager" class="form-label"><b>Контактное лицо</b></label> 
                <input type="text" class="form-input-text" maxlength="40" 
                       value=<?php echo '"',$showing_ad[SHOWING_AD_MANAGER],'"';?>
                       name="manager" id="fld_manager">
                <em class="f_r_g">&nbsp;&nbsp;необязательно</em>
            </div>
            
            <div class="form-row"> <label for="fld_email" class="form-label">Электронная почта</label>
                <input type="text" class="form-input-text" 
                       value=<?php echo '"',$showing_ad[SHOWING_AD_EMAIL],'"';?> name="email" id="fld_email">
            </div>
            
            <div class="form-row-indented"> 
                <label class="form-label-checkbox" for="allow_mails"> 
                    <input type="checkbox" value="1" name="allow_mails"
                        <?php echo $showing_ad[SHOWING_AD_ALLOW_MAILS];?>
                           id="allow_mails" class="form-input-checkbox">
                    <span class="form-text-checkbox">Я не хочу получать вопросы по объявлению по e-mail</span> 
                </label> 
            </div>
            
            <div class="form-row"> 
                <label id="fld_phone_label" for="fld_phone" class="form-label">Номер телефона</label> 
                <input type="text" class="form-input-text" 
                       value=<?php echo '"',$showing_ad[SHOWING_AD_PHONE],'"';?> name="phone" id="fld_phone">
            </div>
            
            <div id="f_location_id" class="form-row form-row-required"> 
                <label for="region" class="form-label">Город</label> 
                <select title="Выберите Ваш город" name="location_id" id="region" class="form-input-select"> 
                    <option value="">-- Выберите город --</option>
                    <option class="opt-group" disabled="disabled">-- Города --</option>
                    <?php print_options_of_cities($showing_ad[SHOWING_AD_LOCATION_ID]);?>
<!--                    <option selected="" data-coords=",," value="641780">Новосибирск</option>   
                    <option data-coords=",," value="641490">Барабинск</option>   
                    <option data-coords=",," value="641510">Бердск</option>   
                    <option data-coords=",," value="641600">Искитим</option>   
                    <option data-coords=",," value="641630">Колывань</option>   
                    <option data-coords=",," value="641680">Краснообск</option>   
                    <option data-coords=",," value="641710">Куйбышев</option>   
                    <option data-coords=",," value="641760">Мошково</option>   
                    <option data-coords=",," value="641790">Обь</option>   
                    <option data-coords=",," value="641800">Ордынское</option>   
                    <option data-coords=",," value="641970">Черепаново</option>   -->
                    <option id="select-region" value="0">Выбрать другой...</option> 
                </select> 
                
                <div id="f_metro_id"> 
                    <select title="Выберите станцию метро" name="metro_id" id="fld_metro_id" class="form-input-select"> 
                        <option value="">-- Выберите станцию метро --</option>
                        <?php print_options_of_metro_stations($showing_ad[SHOWING_AD_METRO_ID]);?>
<!--                        <option value="2028">Берёзовая роща</option>
                        <option value="2018">Гагаринская</option>
                        <option value="2017">Заельцовская</option>
                        <option value="2029">Золотая Нива</option>
                        <option value="2019">Красный проспект</option>
                        <option value="2027">Маршала Покрышкина</option>
                        <option value="2021">Октябрьская</option>
                        <option value="2025">Площадь Гарина-Михайловского</option>
                        <option value="2020">Площадь Ленина</option>
                        <option value="2024">Площадь Маркса</option>
                        <option value="2022">Речной вокзал</option>
                        <option value="2026">Сибирская</option>
                        <option value="2023">Студенческая</option>-->
                    </select> 
                </div> 
                
                <div id="f_district_id"> 
                    <select title="Выберите район города" name="district_id" id="fld_district_id" class="form-input-select" style="display: none;"> 
                        <option value="">-- Выберите район города --</option>
                    </select> 
                </div> 
                
                <div id="f_road_id"> 
                    <select title="Выберите направление" name="road_id" id="fld_road_id" class="form-input-select" style="display: none;"> 
                        <option value="">-- Выберите направление --</option>
                        <option value="56">Бердское шоссе</option>
                        <option value="57">Гусинобродское шоссе</option>
                        <option value="53">Дачное шоссе</option>
                        <option value="55">Краснояровское шоссе</option>
                        <option value="54">Мочищенское шоссе</option>
                        <option value="52">Ордынское  шоссе</option>
                        <option value="58">Советское шоссе</option>
                    </select> 
                </div> 
            </div>
            
            <div class="form-row"> 
                <label for="fld_category_id" class="form-label">Категория</label>
                <select title="Выберите категорию объявления" name="category_id" id="fld_category_id" class="form-input-select"> 
                    <option value="">-- Выберите категорию --</option>
                    <optgroup label="Транспорт">
                        <?php print_options_of_category(CATEGORY_TRANSPORT,$showing_ad[SHOWING_AD_CATEGORY_ID]);?>
                        <!--<option value="9">Автомобили с пробегом</option>-->
                        <!--<option value="109">Новые автомобили</option>-->
                        <!--<option value="14">Мотоциклы и мототехника</option>-->
                        <!--<option value="81">Грузовики и спецтехника</option>-->
                        <!--<option value="11">Водный транспорт</option>-->
                        <!--<option value="10">Запчасти и аксессуары</option>-->
                    </optgroup>
                    
                    <optgroup label="Недвижимость">
                        <?php print_options_of_category(CATEGORY_TRANSPORT,$showing_ad[SHOWING_AD_CATEGORY_ID]);?>
                        <!--<option value="24">Квартиры</option>-->
                        <!--<option value="23">Комнаты</option>-->
                        <!--<option value="25">Дома, дачи, коттеджи</option>-->
                        <!--<option value="26">Земельные участки</option>-->
                        <!--<option value="85">Гаражи и машиноместа</option>-->
                        <!--<option value="42">Коммерческая недвижимость</option>-->
                        <!--<option value="86">Недвижимость за рубежом</option>-->
                    </optgroup>
                    
                    <optgroup label="Работа">
                        <?php print_options_of_category(CATEGORY_JOB,$showing_ad[SHOWING_AD_CATEGORY_ID]);?>
                        <!--<option value="111">Вакансии (поиск сотрудников)</option>-->
                        <!--<option value="112">Резюме (поиск работы)</option>-->
                    </optgroup>
                    
                    <optgroup label="Услуги">
                        <?php print_options_of_category(CATEGORY_SERVICIES,$showing_ad[SHOWING_AD_CATEGORY_ID]);?>
                        <!--<option value="114">Предложения услуг</option>-->
                        <!--<option value="115">Запросы на услуги</option>-->
                    </optgroup>
                    
                    <optgroup label="Личные вещи">
                        <?php print_options_of_category(CATEGORY_PERSONALIA,$showing_ad[SHOWING_AD_CATEGORY_ID]);?>
                        <!--<option value="27">Одежда, обувь, аксессуары</option>-->
                        <!--<option value="29">Детская одежда и обувь</option>-->
                        <!--<option value="30">Товары для детей и игрушки</option>-->
                        <!--<option value="28">Часы и украшения</option>-->
                        <!--<option value="88">Красота и здоровье</option>-->
                    </optgroup>
                    
                    <optgroup label="Для дома и дачи">
                        <?php print_options_of_category(CATEGORY_FOR_HOME,$showing_ad[SHOWING_AD_CATEGORY_ID]);?>
                        <!--<option value="21">Бытовая техника</option>-->
                        <!--<option value="20">Мебель и интерьер</option>-->
                        <!--<option value="87">Посуда и товары для кухни</option>-->
                        <!--<option value="82">Продукты питания</option>-->
                        <!--<option value="19">Ремонт и строительство</option>-->
                        <!--<option value="106">Растения</option>-->
                    </optgroup>
                    
                    <optgroup label="Бытовая электроника">
                        <?php print_options_of_category(CATEGORY_CONSUMER_ELECTRONICS,$showing_ad[SHOWING_AD_CATEGORY_ID]);?>
                        <!--<option value="32">Аудио и видео</option>-->
                        <!--<option value="97">Игры, приставки и программы</option>-->
                        <!--<option value="31">Настольные компьютеры</option>-->
                        <!--<option value="98">Ноутбуки</option>-->
                        <!--<option value="99">Оргтехника и расходники</option>-->
                        <!--<option value="96">Планшеты и электронные книги</option>-->
                        <!--<option value="84">Телефоны</option>-->
                        <!--<option value="101">Товары для компьютера</option>-->
                        <!--<option value="105">Фототехника</option>-->
                    </optgroup>
                    
                    <optgroup label="Хобби и отдых">
                        <?php print_options_of_category(CATEGORY_HOBBY,$showing_ad[SHOWING_AD_CATEGORY_ID]);?>
                        <!--<option value="33">Билеты и путешествия</option>-->
                        <!--<option value="34">Велосипеды</option>-->
                        <!--<option value="83">Книги и журналы</option>-->
                        <!--<option value="36">Коллекционирование</option>-->
                        <!--<option value="38">Музыкальные инструменты</option>-->
                        <!--<option value="102">Охота и рыбалка</option>-->
                        <!--<option value="39">Спорт и отдых</option>-->
                        <!--<option value="103">Знакомства</option>-->
                    </optgroup>
                    
                    <optgroup label="Животные">
                        <?php print_options_of_category(CATEGORY_ANIMALS,$showing_ad[SHOWING_AD_CATEGORY_ID]);?>
                        <!--<option value="89">Собаки</option>-->
                        <!--<option value="90">Кошки</option>-->
                        <!--<option value="91">Птицы</option>-->
                        <!--<option value="92">Аквариум</option>-->
                        <!--<option value="93">Другие животные</option>-->
                        <!--<option value="94">Товары для животных</option>-->
                    </optgroup>
                    
                    <optgroup label="Для бизнеса">                        
                        <?php print_options_of_category(CATEGORY_BUSINESS,$showing_ad[SHOWING_AD_CATEGORY_ID]);?>
                        <!--<option value="116">Готовый бизнес</option>-->
                        <!--<option value="40">Оборудование для бизнеса</option>-->
                    </optgroup>
                </select> 
            </div>

            <div style="display: none;" id="params" class="form-row form-row-required"> 
                <label class="form-label ">
                    Выберите параметры
                </label> 
                <div class="form-params params" id="filters"></div> 
            </div>
            
            <div id="f_map" class="form-row form-row-required hidden">
                <label class="form-label c-2">Укажите местоположение объекта на&nbsp;карте</label> 
                <div class="b-address-map j-address-map disabled"> 
                    <div class="wrapper"> 
                        <div class="map" id="address-map">
                            
                        </div> 
                        <div class="overlay"> 
                            <div class="modal">Сначала <span class="fill-in pseudo-link">укажите адрес</span>
                            </div> 
                        </div> 
                    </div> 
                    
                    <div class="result c-2 hidden"> 
                        <div class="map-success">
                            Маркер указывает на: <span class="address-line"></span>.
                            <span class="confirm pseudo-link hidden">Это верный адрес</span> 
                        </div> 
                        <div class="map-error">Мы не смогли автоматически определить адрес.</div> 
                    </div> 
                    
                    <input type="hidden" disabled="disabled" value="" class="j-address-latitude" name="coords[lat]"> 
                    <input type="hidden" disabled="disabled" value="" class="j-address-longitude" name="coords[lng]"> 
                    <input type="hidden" disabled="disabled" value="" class="j-address-zoom" name="coords[zoom]"> 
                </div>
            </div>
            
            <div id="f_title" class="form-row f_title"> 
                <label for="fld_title" class="form-label">Название объявления</label> 
                <input type="text" maxlength="50" class="form-input-text-long" 
                value=<?php echo '"',$showing_ad[SHOWING_AD_TITLE],'"';?> name="title" id="fld_title"> 
            </div>
            
            <div class="form-row"> 
                <label for="fld_description" class="form-label" id="js-description-label">Описание объявления</label> 
                <textarea maxlength="3000" name="description" id="fld_description" class="form-input-textarea">
                    <?php echo $showing_ad[SHOWING_AD_DESCRIPTION];?>
                </textarea> 
            </div>
            
            <div id="price_rw" class="form-row rl"> 
                <label id="price_lbl" for="fld_price" class="form-label">Цена</label> 
                <input type="text" maxlength="9" class="form-input-text-short" 
                value=<?php echo '"',$showing_ad[SHOWING_AD_PRICE],'"';?> name="price" id="fld_price">
                &nbsp;<span id="fld_price_title">руб.</span> 
                <a class="link_plain grey right_price c-2 icon-link" id="js-price-link" href="/info/pravilnye_ceny?plain">
                    <span>Правильно указывайте цену</span>
                </a> 
            </div>

            <div id="f_images" class="form-row"> 
                <label for="fld_images" class="form-label">
                    <span id="js-photo-label">Фотографии</span>
                    <span class="js-photo-count" style="display: none;"></span>
                </label> 
                <input type="file" value="image" id="fld_images" name="image" accept="image/*" class="form-input-file"> 
                <span style="line-height:22px;color: gray; display: none;" id="fld_images_toomuch">Вы добавили максимально возможное количество фотографий</span>
                <span style="display: none;" id="fld_images_overhead"></span> 
            </div> 
            
            <div style="display: none; margin-top: 0px;" class="form-row-indented images" id="files">
                <div style="display: none;" id="progress"> 
                    <table><tbody><tr><td> <div><div></div></div> </td></tr></tbody></table> 
                </div> 
            </div>

            <div class="form-row-indented form-row-submit b-vas-submit" id="js_additem_form_submit">
                <div class="vas-submit-button pull-left"> 
                    <span class="vas-submit-border"></span> 
                    <span class="vas-submit-triangle"></span> 
                    <input type="submit" value="Далее" id="form_submit" name="main_form_submit" class="vas-submit-input"> 
                </div>
            </div>
        </form>         
        
<!--    </body>
</html>-->



