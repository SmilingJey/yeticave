<?php

require_once 'utils/init.php';

function searchUserByEmail($db_link, $email) {
    $safe_email = mysqli_real_escape_string($db_link, $email);
    $user_by_email_query = "SELECT * FROM `users` WHERE email='$safe_email' LIMIT 1";
    $user_result = mysqli_query($db_link, $user_by_email_query);
    $user_data = mysqli_fetch_assoc($user_result);
    return $user_data;
}

$is_post = $_SERVER['REQUEST_METHOD'] == 'POST';

if (isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}

$form = [];
$errors = [];

if ($is_post) {
    foreach ($_POST as $key => $value) {
        $form[$key] = trim($value);
    }

    $required = [
        'email' => 'Введите email',
        'password' => 'Введите пароль',
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

    if (empty($errors['email']) && empty($errors['password'])) {
        $user = searchUserByEmail($db_link, $form['email']);
        if (!$user) {
            $errors['email'] = 'Такого пользователя не существует';
        } else if (!password_verify($form['password'], $user['password'])) {
            $errors['password'] = 'Неверный пароль';
        }
    }
}

if ($is_post && empty($errors)) {
    $_SESSION['user'] = $user;
    header("Location: /");
    exit();
} else {
    $form_template = renderTemplate('templates/signin-form.php', [
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
