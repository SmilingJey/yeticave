<?php

session_start();

require_once 'data/nav.php';
require_once 'utils/template-engine.php';
require_once 'utils/utils.php';
require_once 'utils/mysql_helper.php';

require_once 'utils/init.php';

checkAuth();

$lot = [];
$errors = [];

$is_post = $_SERVER['REQUEST_METHOD'] == 'POST';

if ($is_post) {
    foreach ($_POST as $key => $value) {
        $lot[$key] = cleanString($value);
    }

    $required = [
        'lot-name' => 'Введите наименование лота',
        'category' => 'Выберите категорию',
        'message' => 'Напишите описание лота',
        'lot-rate' => 'Введите начальную цену',
        'lot-step' => 'Введите шаг ставки',
        'lot-date' => 'Введите дату завершения торгов'
    ];

    foreach ($required as $key => $error) {
        if (empty($lot[$key])) {
            $errors[$key] = $error;
        }
    }

    if (!empty($lot['lot-rate']) && !is_numeric($lot['lot-rate'])) {
        $errors['lot-rate'] = 'Введите целое число';
    }

    if (!empty($lot['lot-step']) && !is_numeric($lot['lot-step'])) {
        $errors['lot-step'] = 'Введите целое число';
    }

    if (!empty($lot['category'])) {
        $lot['category_id'] = 0;
        foreach ($categories_data as $categoty) {
            if ($lot['category'] === $categoty['name']) {
                $lot['category_id'] = $categoty['id'];
                break;
            }
        }
        if (!$lot['category_id']) {
            $errors['category'] = 'Выберите категорию';
        }
    }

    if (!empty($lot['lot-date']) && !validateDate($lot['lot-date'])) {
        $errors['lot-date'] = 'Выберите корректную дату';
    }

    if (empty($_FILES['photo']['name'])) {
        $errors['photo'] = 'Выберите изображение лота';
    } else {
        $tmp_name = $_FILES['photo']['tmp_name'];
        $path = $_FILES['photo']['name'];
        if (!is_image($tmp_name)) {
            $errors['photo'] = 'Выбранное изображения не картинка';
        }
    }
}

if ($is_post && empty($errors)) {
    if (!empty($_FILES['photo']['name'])) {
        $path = 'uploads/lot-images';
        $file_ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $file_name = get_random_file_name($path, $file_ext).'.'.$file_ext;
        $lot['image'] = $path.'/'.$file_name;
        $upload_path = __DIR__.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.
                      'lot-images'.DIRECTORY_SEPARATOR.$file_name;
    }

    $sql = 'INSERT INTO lots (`name`, `description`, `image`, `start_price`,
                              `step`, `date`, `category_id`, `user_id` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($db_link, $sql, [
        $lot['lot-name'],
        $lot['message'],
        $lot['image'],
        $lot['lot-rate'],
        $lot['lot-step'],
        $lot['lot-date'],
        $lot['category_id'],
        $_SESSION['user']['id']
    ]);
    $res = mysqli_stmt_execute($stmt);
    if (!$res) {
        $errors['db'] = 'Ошибка создания лота: '.mysqli_error($db_link);
    } else {
        move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path);
    }
}

if (!$is_post || !empty($errors)) {
    $form_template = renderTemplate('templates/add-lot-form.php',  [
        'fields' => $lot,
        'errors' => $errors,
        'categories' => $categories_data
    ]);
} else {
    $last_id = mysqli_insert_id($db_link);
    if ($last_id) {
        header("Location: /lot.php?id={$last_id}");
    } else {
        header("Location: /");
    }

    exit();
}

$inner_template = renderTemplate('templates/inner.php', [
    'nav' => $categories_data,
    'content' => $form_template
]);

$layout_template = renderTemplate('templates/layout.php', [
    'title' => 'Создание лота',
    'user' => $_SESSION['user'],
    'content' => $inner_template
]);

print($layout_template);
