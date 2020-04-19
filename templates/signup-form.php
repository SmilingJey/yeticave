<form class="form container" id="signup-form" <?= !empty($data['errors']) ? 'form--invalid' : '' ?>
      action="signup.php" method="post" enctype="multipart/form-data">
    <p class="form__error"><?= $data['errors']['db'] ?></p>
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item <?= !empty($data['errors']['email']) ? 'form__item--invalid' : '' ?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail"
               value="<?= $data['fields']['email'] ?>">
        <span class="form__error"><?= $data['errors']['email'] ?></span>
    </div>
    <div class="form__item <?= !empty($data['errors']['password']) ? 'form__item--invalid' : '' ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?= $data['errors']['password'] ?></span>
    </div>
    <div class="form__item <?= !empty($data['errors']['password']) ? 'form__item--invalid' : '' ?>">
        <label for="password-repeat">Повторите пароль*</label>
        <input id="password-repeat" type="password" name="password-repeat" placeholder="Повторите пароль">
        <span class="form__error">Пароли должны совпадать</span>
    </div>
    <div class="form__item <?= !empty($data['errors']['name']) ? 'form__item--invalid' : '' ?>">
        <label for="name">Имя*</label>
        <input id="name" type="text" name="name" placeholder="Введите имя"
               value="<?= $data['fields']['name'] ?>">
        <span class="form__error"><?= $data['errors']['name'] ?></span>
    </div>
    <div class="form__item <?= !empty($data['errors']['message']) ? 'form__item--invalid' : '' ?>">
        <label for="message">Контактные данные*</label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= $data['fields']['message'] ?></textarea>
        <span class="form__error"><?= $data['errors']['message'] ?></span>
    </div>
    <div class="form__item form__item--file form__item--last">
        <label>Аватар</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden js-image-file-input" type="file" id="photo" name="avatar" value="">
            <label for="photo">
                <span>+ Добавить</span>
            </label>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="signin.php">Уже есть аккаунт</a>
</form>
