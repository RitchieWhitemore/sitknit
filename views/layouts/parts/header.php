<?php

use app\widgets\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Url;

/**
 * @var $this \yii\web\View
 */
?>

<header class="page-header">
    <div class="page-header__user-menu">
        <ul class="page-header__user-list">
            <?php if (Yii::$app->user->identity) : ?>
                <li><a class="link page-header__user-item" href="<?= Url::to(['/user/profile']) ?>">Личный кабинет</a> |
                </li>
                <li><a class="link page-header__user-item" href="<?= Url::to(['/logout']) ?>">Выйти</a></li>
            <?php else : ?>
                <li><a class="link page-header__user-item" href="<?= Url::to(['/login']) ?>">Войти</a> |</li>
                <li><a class="link page-header__user-item" href="<?= Url::to(['/signup']) ?>">Регистрация</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="page-header__wrapper">
        <ul class="page-header__social">
            <li class="page-header__social-item"><a href="https://ok.ru/"><img src="/img/ok.svg" width="30"
                                                                               alt="Группа в Однокласниках"></a>
            </li>
            <li class="page-header__social-item"><a href="https://vk.com"><img src="/img/vk.svg" width="30"
                                                                               alt="Группа во Вконтакте"></a></li>
        </ul>
        <div class="page-header__logo-wrapper">
            <img class="page-header__ravels" src="/img/logo-second.png" width="466" height="160">
            <img class="page-header__logo" src="/img/logo-first.png" width="349" height="99">
            <span class="page-header__phone">8-800-000-00-00</span>
        </div>
        <?= \app\modules\cart\widgets\CartInfoWidget::widget() ?>
    </div>

    <?php
    NavBar::begin([
        'options' => [
            'screenReaderToggleText' => 'Menu',
            'id' => 'menu',
            'class' => 'main-nav main-nav--closed main-nav--nojs',
        ],
    ]);
    /*echo '<h2 id="nav-title" class="main-nav__title"></h2>';*/
    $menuItems = [
        [
            'label' => 'Главная',
            'url' => ['/'],
            'options' => ['class' => 'main-nav__item'],
            'linkOptions' => ['class' => 'main-nav__link'],
        ],
        [
            'label' => 'Каталог',
            'url' => ['/catalog'],
            'active' => in_array(\Yii::$app->controller->id, ['catalog']),
            'options' => ['class' => 'main-nav__item'],
            'linkOptions' => ['class' => 'main-nav__link'],
        ],
    ];
    echo '<div class="main-nav__wrapper">';
    echo Nav::widget([
        'options' => ['class' => 'main-nav__list'],
        'items' => $menuItems,

    ]);
    NavBar::end();
    echo '</div>';
    ?>
</header>
