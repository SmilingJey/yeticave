<form class="form container <?= !empty($data['errors']) ? 'form--invalid' : '' ?>"
      action="signin.php" method="post">
    <h2>Вход</h2>
    <div class="form__item <?= !empty($data['errors']['email']) ? 'form__item--invalid' : '' ?>" >
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail"
               value="<?= $data['fields']['email'] ?>" required>
        <span class="form__error"><?= $data['errors']['email'] ?></span>
    </div>
    <div class="form__item form__item--last <?= !empty($data['errors']['password']) ? 'form__item--invalid' : '' ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль"
               value="<?= $data['fields']['password'] ?>" required>
        <span class="form__error"><?= $data['errors']['password'] ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>
