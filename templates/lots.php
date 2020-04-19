<?php
    require_once 'utils/utils.php';
?>

<section class="lots">
    <div class="lots__header">
        <h2><?= $data['lots_header'] ?></h2>
        <?= $data['lots_buttons'] ?>
    </div>
    <ul class="lots__list">
        <?php foreach ($data['lots'] as $lot_id => $lot) : ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= $lot['image'] ?>" width="350" height="260" alt="<?= $lot['category'] ?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $lot['category'] ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $lot['id'] ?>"><?= $lot['name'] ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= getFormattedCost($lot['cost']) ?></span>
                        </div>
                        <div class="lot__timer timer"><?= getEndTime($lot['endtime']) ?></div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
