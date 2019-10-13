<?php

use app\assets\AppAsset;
use app\widgets\Alert;
use app\widgets\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Html;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <title>Сижу-Вяжу - Главная</title>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?= Html::csrfMetaTags() ?>
        <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&amp;subset=cyrillic" rel="stylesheet">
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

    </head>
    <body>
    <?php $this->beginBody() ?>
    <header class="page-header">
        <div class="page-header__user-menu">
            <ul class="page-header__user-list">
                <li><a class="link page-header__user-item" href="login.html">Войти</a> |</li>
                <li><a class="link page-header__user-item" href="sign.html">Регистрация</a></li>
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
            <div class="page-header__cart-wrapper">
                <img class="page-header__cart" src="/img/header-cart.svg" width="37">
                <div class="page-header__cart-text-wrapper">
                    <span class="page-header__cart-quantity"><b>товаров: </b>3</span>
                    <span class="page-header__cart-summ"><b>на сумму: </b>524 руб.</span>
                </div>
                <a href="#" class="page-header__cart-btn btn">Оформить заказ</a>
            </div>
        </div>

        <?php
        NavBar::begin([
            'options' => [
                'screenReaderToggleText' => 'Menu',
                'id'                     => 'menu',
                'class'                  => 'main-nav main-nav--closed main-nav--nojs',
            ],
        ]);
        /*echo '<h2 id="nav-title" class="main-nav__title"></h2>';*/
        $menuItems = [
            [
                'label'       => 'Главная',
                'url'         => ['/'],
                'options'     => ['class' => 'main-nav__item'],
                'linkOptions' => ['class' => 'main-nav__link'],
            ],
            [
                'label'       => 'Каталог',
                'url'         => ['/catalog'],
                'active'      => in_array(\Yii::$app->controller->id, ['catalog']),
                'options'     => ['class' => 'main-nav__item'],
                'linkOptions' => ['class' => 'main-nav__link'],
            ],
        ];
        echo '<div class="main-nav__wrapper">';
        echo Nav::widget([
            'options' => ['class' => 'main-nav__list'],
            'items'   => $menuItems,

        ]);
        NavBar::end();
        echo '</div>';
        ?>
    </header>
    <main class="main__body">
        <div class="container">
            <?= Alert::widget() ?>
            <div class="filter__button-wrapper">
                <button class="filter__button filter__button--closed">Фильтр <span class="filter__arrow"></span>
                </button>
            </div>
            <section class="main__content">
                <aside class="main__left-column">
                    <?= \app\widgets\CategoriesWidget::widget(['context' => $this->context]) ?>
                    <?= \app\widgets\GoodFilterWidget::widget() ?>
                </aside>
                <div class="main__page-content">
                    <?= $content ?>
                </div>
            </section>
        </div>
    </main>
    <footer class="page-footer">
        <div class="container-fluid">

            <section class="page-footer__menu">
                <h2 class="page-footer__title">Меню</h2>
                <ul class="page-footer__menu-list">
                    <li class="page-footer__menu-item"><a class="link page-footer__menu-link" href="#">Главная</a></li>
                    <li class="page-footer__menu-item"><a class="link page-footer__menu-link" href="#">Каталог</a></li>
                    <li class="page-footer__menu-item"><a class="link page-footer__menu-link" href="#">Доставка</a></li>
                    <li class="page-footer__menu-item"><a class="link page-footer__menu-link" href="#">Оплата</a></li>
                    <li class="page-footer__menu-item"><a class="link page-footer__menu-link" href="#">Контакты</a></li>
                </ul>
            </section>

            <section class="page-footer__social">
                <h2 class="page-footer__title">Мы в социальных сетях</h2>
                <a class="link page-footer__social-item page-footer__social-item--ok" href="#">Однокласники</a>
                <a class="link page-footer__social-item page-footer__social-item--vk" href="#">Вконтакте</a>
            </section>

            <section class="page-footer__contact">
                <h2 class="page-footer__title">Контакты</h2>
                <p>8-800-000-00-00</p>
                <p>info@siju-vyaju.ru</p>
            </section>
        </div>

        <div class="page-footer__bottom-row">

            <p class="page-footer__copyright">© Сижу вяжу, 2016. Все права защищены.</p>

            <div class="page-footer__logo-wrapper">
                <img src="/img/logo-footer.png"/>
            </div>

            <ul class="page-footer__card-payment-list">
                <li><img src="/img/mastercard.svg" width="40" height="27" alt="MasterCard"></li>
                <li><img src="/img/visa.svg" width="40" height="27" alt="Visa"></li>
            </ul>
        </div>

    </footer>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>