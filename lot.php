<?php

require_once 'data/lots.php';
require_once 'utils/template-engine.php';
require_once 'utils/utils.php';
require_once 'utils/mysql_helper.php';
require_once 'utils/init.php';


function searchLogById($db_link, $id) {
    $safe_id = mysqli_real_escape_string($db_link, $id);
    $query = "
        SELECT l.*,
               c.name AS category
          FROM lots l
          JOIN categories c
            ON l.category_id = c.id
         WHERE l.id='$safe_id'
         LIMIT 1
    ";
    $result = mysqli_query($db_link, $query);
    return mysqli_fetch_assoc($result);
}

function searchBetsByLotId($db_link, $id) {
    $safe_id = mysqli_real_escape_string($db_link, $id);
    $query = "
        SELECT u.name AS name,
               b.bet AS bet,
               DATE_FORMAT(b.create_time, '%d.%m.%y в %H:%i') AS time
          FROM bets b
          JOIN users u
            ON b.user_id = u.id
         WHERE b.lot_id=$safe_id
         ORDER BY b.bet DESC
    ";
    $result = mysqli_query($db_link, $query);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_max_bet($bets, $min_bet = 0) {
    $max = $min_bet;
    foreach ($bets as $bet) {
        if ($bet['bet'] > $max) $max = $bet['bet'];
    }
    return $max;
}

function post_bet($lot_id, $bet, $user_id, $bet_step) {
    global $db_link;
    checkAuth();
    $bets = searchBetsByLotId($db_link, $lot_id);
    $max_bat = get_max_bet($bets);
    $min_bat = $max_bat + $bet_step;
    if ($bet < $min_bat) return "Ставка не может быть меньше {$min_bat}";
    $sql = 'INSERT INTO bets (`bet`, `lot_id`, `user_id`) VALUES (?, ?, ?)';
    $stmt = db_get_prepare_stmt($db_link, $sql, [
        $bet, $lot_id, $user_id
    ]);
    $res = mysqli_stmt_execute($stmt);
    if (!$res) return 'Ошибка при добавлении ставки: '.mysqli_error($db_link);
    return '';
}

$lot = null;

if (isset($_GET['id'])) {
    $lot_id = $_GET['id'];
    $lot = searchLogById($db_link, $lot_id);
}

if ($lot && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $bet = cleanString($_POST['bet']);
    $lot['bet_error'] = post_bet($lot_id, $bet, $_SESSION['user']['id'], $lot['step']);
}

if ($lot) {
    $lot['bets'] = searchBetsByLotId($db_link, $lot_id);
    $lot['max_bet'] = get_max_bet($lot['bets'], $lot['start_price']);
    $lot['min_bet'] = $lot['max_bet'] + $lot['step'];
    $lot_template = renderTemplate('templates/lot.php', $lot);
} else {
    http_response_code(404);
    $lot_template = renderTemplate('templates/404.php', [
        'text' => 'Лот с идентефикатором "'.$_GET['id'].'" не найден.'
    ]);
}

$inner_template = renderTemplate('templates/inner.php', [
    'nav' => $categories_data,
    'content' => $lot_template
]);

$layout_template = renderTemplate('templates/layout.php', [
    'title' => $lot['name'],
    'user' => $_SESSION['user'],
    'content' => $inner_template
]);

$history = getLotsHistoryFromCookies();
if (!in_array($lot_id, $history)) {
    array_push($history, $lot_id);
}
setcookie('history', json_encode($history), strtotime("+10 years") , "/");

print($layout_template);
