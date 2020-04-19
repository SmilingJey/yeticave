<?php

require_once 'utils/init.php';

if (isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}

require_once 'data/users.php';
require_once 'utils/template-engine.php';
require_once 'utils/mysql_helper.php';

$is_post = $_SERVER['REQUEST_METHOD'] == 'POST';
$form = [];
$errors = [];

if ($is_post) {
    foreach ($_POST as $key => $value) {
        $form[$key] = trim($value);
    }

    $required = [
        'email' => 'Введите email',
        'password' => 'Введите пароль',
        'name' => 'Введите имя',
        'message' => 'Напишите как с вами связаться',
    ];

    foreach ($required as $key => $error) {
        if (empty($form[$key])) {
            $errors[$key] = $error;
        }
    }

    if (empty($errors['email']) && !filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите корректный email';
    }

    if (empty($errors['password']) && strlen($form['password']) < 6) {
        $errors['password'] = 'Пароль должен быть не меньше 6 символов';
    }
}

if ($is_post && empty($errors)) {
    if (!empty($_FILES['avatar']['name'])) {
        $path = 'uploads/avatars';
        $file_ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $file_name = get_random_file_name($path, $file_ext).'.'.$file_ext;
        $form['image'] = $path.'/'.$file_name;
        $upload_path = __DIR__.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'avatars'.DIRECTORY_SEPARATOR.$file_name;
    }

    $sql = 'INSERT INTO users (`email`, `password`, `name`, `contact`, `avatar`) VALUES (?, ?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($db_link, $sql, [
        $form['email'],
        password_hash($form['password'], PASSWORD_DEFAULT),
        $form['name'],
        $form['message'],
        $form['image'] ?? ''
    ]);
    $res = mysqli_stmt_execute($stmt);
    if (!$res) {
        if (mysqli_errno($db_link) == MYSQLI_CODE_DUPLICATE_KEY) {
            $errors['db'] = 'Пользователь с таким именем или email уже существует';
        }else {
            $errors['db'] = 'Ошибка создания пользователя: '.mysqli_error($db_link);
        }
    } else {
        move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_path);
    }
}

if ($is_post && empty($errors)) {
    header("Location: /signin.php");
    exit();
} else {
    $form_template = renderTemplate('templates/signup-form.php', [
        'fields' => $form,
        'errors' => $errors,
    ]);
}

$inner_template = renderTemplate('templates/inner.php', [
    'nav' => $categories_data,
    'content' => $form_template
]);

$layout_template = renderTemplate('templates/layout.php', [
    'title' => 'Регистрация',
    'user' => $_SESSION['user'],
    'content' => $inner_template
]);

print($layout_template);
