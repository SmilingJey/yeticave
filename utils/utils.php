<?php

$config = require_once 'config/config.php';

function getFormattedCost($cost) {

    $formatted_cost = number_format((int)$cost, 0, ',', ' ');
    return $formatted_cost.'<b class="rub">р</b>';
}

function getEndTime($time) {
    $timer = $time - time();
    return gmdate('G:i:s', $timer);
}

function cleanString($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);

    return $value;
}

function is_image($path) {
    $a = getimagesize($path);
    $image_type = $a[2];
    return in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP));
}

function validateDate($date, $format = 'Y-m-d') {
    $date = DateTime::createFromFormat($format, $date);
    $errors = DateTime::getLastErrors();
    return empty($errors['warning_count']);
}

function getLotsHistoryFromCookies() {
    $history = [];
    if (isset($_COOKIE['history'])) {
        $history = json_decode($_COOKIE['history']);
    }
    return is_array($history) ? $history : [];
}

function checkAuth() {
    if (empty($_SESSION['user'])) {
        http_response_code(403);
        header('Location: signin.php');
        exit;
    }
}

function db_error() {

    global $config;
    if (!$config['is_production']) {
        echo "Ошибка работы с MySQL." . PHP_EOL;
        echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    }
    http_response_code(500);
    echo http_response_code();
    exit;
}

function get_random_file_name($path, $extension='') {
    $extension = $extension ? '.' . $extension : '';
    $path = $path ? $path . '/' : '';

    do {
        $name = uniqid();
        $file = $path . $name . $extension;
    } while (file_exists($file));

    return $name;
}
