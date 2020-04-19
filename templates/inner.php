<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($data['nav'] as $nav_id => $nav_item) : ?>
                <li class="nav__item <?= $nav_id === $data['nav_avtive'] ? 'nav__item--current' : '' ?>">
                    <a href="<?= $nav_item['url'] ?>"><?= $nav_item['name'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <div class="container">
        <?= $data['content'] ?>
    </div>
</main>



