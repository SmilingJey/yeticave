<form class="form form--add-lot container
<?= !empty($data['errors']) ? 'form--invalid' : '' ?>" action="add.php" method="post"
enctype="multipart/form-data"
>
    <span class="form__error form__error--bottom"><?= $data['errors']['db'] ?></span>
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item <?= !empty($data['errors']['lot-name']) ? 'form__item--invalid' : '' ?>">
            <label for="lot-name">Наименование</label>
            <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота"
                   value="<?= $data['fields']['lot-name'] ?>">
            <span class="form__error"><?= $data['errors']['lot-name'] ?></span>
        </div>
        <div class="form__item <?= !empty($data['errors']['category']) ? 'form__item--invalid' : '' ?>">
            <label for="category">Категория</label>
            <select id="category" name="category">
                <option>Выберите категорию</option>
                <?php foreach ($data['categories'] as $category) : ?>
                <option <?= $category['name'] == $data['fields']['category'] ? 'selected' : ''?>>
                    <?= $category['name'] ?>
                </option>
                <?php endforeach; ?>
            </select>
            <span class="form__error"><?= $data['errors']['category'] ?></span>
        </div>
    </div>
    <div class="form__item form__item--wide <?= !empty($data['errors']['message']) ? 'form__item--invalid' : '' ?>">
        <label for="message">Описание</label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"><?= $data['fields']['message'] ?></textarea>
        <span class="form__error"><?= $data['errors']['message'] ?></span>
    </div>
    <div class="form__item form__item--file"> <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="" width="113" height="113" alt="Изображение лота">
            </div>
        </div>
        <div class="form__input-file <?= !empty($data['errors']['photo']) ? 'form__item--invalid' : '' ?>">
            <input class="visually-hidden js-image-file-input" type="file" id="photo" name="photo">
            <label for="photo">
                <span>+ Добавить</span>
            </label>
            <span class="form__error"><?= $data['errors']['photo'] ?></span>
        </div>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small <?= !empty($data['errors']['lot-rate']) ? 'form__item--invalid' : '' ?>">
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?= $data['fields']['lot-rate'] ?>">
            <span class="form__error"><?= $data['errors']['lot-rate'] ?></span>
        </div>
        <div class="form__item form__item--small <?= !empty($data['errors']['lot-step']) ? 'form__item--invalid' : '' ?>">
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?= $data['fields']['lot-step'] ?>" >
            <span class="form__error"><?= $data['errors']['lot-step'] ?></span>
        </div>
        <div class="form__item <?= !empty($data['errors']['lot-date']) ? 'form__item--invalid' : '' ?>">
            <label for="lot-date">Дата окончания торгов</label>
            <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?= $data['fields']['lot-date'] ?>" >
            <span class="form__error"><?= $data['errors']['lot-date'] ?></span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>
