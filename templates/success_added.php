<section class="success-add">
    <h2 class="success-add__header">Лот добавлен:</h2>
    <p class="success-add__text">
        <span class="sussess-add__bold">Имя лота: </span><?= $data['lot-name'] ?>
    </p>
    <p class="success-add__text">
        <span class="sussess-add__bold">Категория: </span><?= $data['category'] ?>
    </p>
    <p class="success-add__text">
        <span class="sussess-add__bold">Описание: </span><?= $data['message'] ?>
    </p>
    <p class="success-add__text">
        <span class="sussess-add__bold">Начальная цена: </span><?= $data['lot-rate'] ?>
    </p>
    <p class="success-add__text">
        <span class="sussess-add__bold">Шаг ставки: </span><?= $data['lot-step'] ?>
    </p>
    <p class="success-add__text">
        <span class="sussess-add__bold">Дата окончания торгов: </span><?= $data['lot-date'] ?>
    </p>
    <p class="success-add__text">
        <span class="sussess-add__bold">Изображение: </span><?= $data['image'] ?>
    </p>
    <div class="success-add__image-container">
        <img class="success_add__class" src="<?= $data['image'] ?>" alt="фото лота">
    </div>
    <p class="success__add__text">
        <a class="success__add__link" href="/">← Вернуться назад</a>
    </p>
</section>
