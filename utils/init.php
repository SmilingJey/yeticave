<?php

require_once 'utils/utils.php';
require_once 'config/db.php';
require_once 'utils/template-engine.php';

session_start();
date_default_timezone_set("Europe/Moscow");

$db_link = @mysqli_connect(
    $db_config['host'],
    $db_config['user'],
    $db_config['password'],
    $db_config['database']
);

if (!$db_link) db_error();

mysqli_set_charset($db_link, 'utf8');

$categories_query = 'SELECT `id`, `name`, `url`, `promo_class` FROM categories';
$categories_result = mysqli_query($db_link, $categories_query);

if (!$categories_result) db_error();

$categories_data = mysqli_fetch_all($categories_result, MYSQLI_ASSOC);





