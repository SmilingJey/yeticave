<?php

session_start();

require_once 'data/nav.php';
require_once 'data/lots.php';
require_once 'utils/template-engine.php';
require_once 'utils/utils.php';

checkAuth();

date_default_timezone_set("Europe/Moscow");
$history_lots = [];
$history = getLotsHistoryFromCookies();
foreach ($history as $lot_id) {
    array_push($history_lots, $lots_data[$lot_id]);
}

$lots = renderTemplate('templates/lots.php', [
    'lots_header' => empty($history_lots) ? 'Нет просмотренных лотов' : 'Просмотренные лоты',
    'lots_buttons' => empty($history_lots) ? '' : '<button class="lots_clear">Очистить</button>',
    'lots' => $history_lots,
]);

$inner_template = renderTemplate('templates/inner.php', [
    'nav' => $categories_data,
    'content' => $lots
]);

$layout_template = renderTemplate('templates/layout.php', [
    'title' => 'Просмотренные лоты',
    'user' => $_SESSION['user'],
    'content' => $inner_template
]);

print($layout_template);
