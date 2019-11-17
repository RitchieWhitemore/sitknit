<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="breadcrumb">
    <ul class="breadcrumb__list">
        <li class="breadcrumb__item"><a href="/" class="link breadcrumb__link">Главная</a></li>
        <li class="breadcrumb__item">Кабинет</li>
    </ul>
</div>

<div class="content">
    <div class="content__title-wrapper">
        <h1 class="content__title">Личный кабинет</h1>
    </div>

    <div class="row" style="display: flex; margin-bottom: 25px">
        <?= Html::a('Редактирование профиля', ['update'],
            ['class' => 'btn btn-primary', 'style' => 'margin-right: 15px']) ?>
        <?= Html::a('Смена пароля', ['password-change'], ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="cabinet">

        <img class="cabinet__photo" src="<?= $model->getUploadedFileUrl('photo') ?>" alt="">

        <div class="cabinet__content">
            <h2 class="cabinet__content-title"><?= $model->getFullName() ?></h2>
            <p>
                <b>Адрес</b>: <?= !empty($model->partner->address) ? $model->partner->address : 'Не заполнено ' . Html::a('Редактирование профиля',
                        ['update']); ?></p>
            <?php if (!empty($model->partner->orders)): ?>
                <table>
                    <tr>
                        <td class="field">Всего сделано:</td>
                        <td class="value">20 заказов</td>
                    </tr>
                    <tr>
                        <td class="field">На сумму:</td>
                        <td class="value">59 258 руб.</td>
                    </tr>
                </table>
            <?php endif; ?>
        </div>

        <?php if (!empty($model->partner->orders)): ?>
            <div class="cabinet__orders">
                <div class="cabinet__orders-title-wrapper">
                    <h2 class="cabinet__orders-title">Заказы</h2>
                </div>

                <table class="table-orders">
                    <tr class="table-orders__header">
                        <th>Заказ</th>
                        <th>Статус</th>
                        <th>Сумма</th>
                    </tr>
                    <tr>
                        <td class="table-orders__order"><a href="">Заказ № 1265 от 01 февраля 2020 г.</a></td>
                        <td class="table-orders__status">Отгружен</td>
                        <td class="table-orders__sum">2000 Р</td>
                    </tr>
                    <tr>
                        <td class="table-orders__order"><a href="">Заказ № 1265 от 01 февраля 2020 г.</a></td>
                        <td class="table-orders__status">Отгружен</td>
                        <td class="table-orders__sum">2000 Р</td>
                    </tr>
                    <tr>
                        <td class="table-orders__order"><a href="">Заказ № 1265 от 01 февраля 2020 г.</a></td>
                        <td class="table-orders__status">Отгружен</td>
                        <td class="table-orders__sum">2000 Р</td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
