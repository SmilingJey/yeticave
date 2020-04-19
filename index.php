<?php

session_start();

require_once 'data/lots.php';
require_once 'utils/template-engine.php';
require_once 'utils/init.php';

$lots = renderTemplate('templates/lots.php', [
    'lots_header' => 'Открытые лоты',
    'lots' => $lots_data,
]);

$index = renderTemplate('templates/index.php', [
    'promo' => $categories_data,
    'content' => $lots
]);

$layout = renderTemplate('templates/layout.php', [
    'title' => 'Главная',
    'user' => $_SESSION['user'],
    'content' => $index
]);

print($layout);
