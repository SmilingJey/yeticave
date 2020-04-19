<?php
    require_once 'utils/utils.php';
?>

<section class="lot-item">
    <h2><?= $data['name']?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= $data['image'] ?>" width="730" height="548" alt="<?= $data['name'] ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= $data['category'] ?></span></p>
            <p class="lot-item__description"><?= $data['description'] ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <div class="lot-item__timer timer"><?= getEndTime($data['endtime']) ?></div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= $data['max_bet'] ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= getFormattedCost($data['min_bet']) ?></span>
                    </div>
                </div>
                <?php if (!empty($data['bet_error'])) : ?>
                    <p class="lot-item__form-error"><?= $data['bet_error'] ?></p>
                <?php endif;  ?>
                <form class="lot-item__form" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">

                    <p class="lot-item__form-item">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="number" name="bet"
                               min="<?= $data['min_bet'] ?>" value="<?= $data['min_bet'] ?>"
                               step="<?= $data['step'] ?>"
                               placeholder="<?= $data['min_bet'] ?>">
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <div class="history">
                <h3>История ставок (<span><?= count($data['bets']) ?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($data['bets'] as $bet) : ?>
                    <tr class="history__item">
                        <td class="history__name"><?= $bet['name'] ?></td>
                        <td class="history__price"><span><?= getFormattedCost($bet['bet']) ?></span></td>
                        <td class="history__time"><?= $bet['time'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>
