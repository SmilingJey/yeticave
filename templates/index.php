<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое
            эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php foreach ($data['promo'] as $promo_item) : ?>
                <li class="promo__item <?= $promo_item['promo_class'] ?>">
                    <a class="promo__link" href="<?= $promo_item['url'] ?>"><?= $promo_item['name'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?= $data['content'] ?>
</main>

