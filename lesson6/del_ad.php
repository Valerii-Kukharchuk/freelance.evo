<?php

session_start();

unset($_SESSION[filter_input(INPUT_GET, 'id')]);

header("Location: show_form_ad.php");
die();

