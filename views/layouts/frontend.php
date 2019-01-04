<?php

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
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
                                                                               alt="Группа в Однокласниках"></a></li>
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
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items'   => array_filter([
            ['label' => 'Home', 'url' => ['/main/default/index']],
            ['label' => 'Contact', 'url' => ['main/contact/index']],
            Yii::$app->user->isGuest ?
                ['label' => 'Sign Up', 'url' => ['/users/default/signup']] :
                false,
            Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' => ['/users/default/login']] :
                ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                 'url' => ['/users/default/logout'],
                 'linkOptions' => ['data-method' => 'post']],
            !Yii::$app->user->isGuest ?
                ['label' => 'Личный кабинет', 'url' => ['/users/profile/index']] :
                false,
        ]),
    ]);
    NavBar::end();
    ?>
    <nav class="main-nav main-nav--closed main-nav--nojs">
        <button class="main-nav__toggle">Открыть меню</button>
        <h2 class="main-nav__title">Главная</h2>
        <div class="main-nav__wrapper">
            <ul class="main-nav__list">
                <li class="main-nav__item main-nav__item--active"><a class="main-nav__link"
                                                                     href="/index.html">Главная</a></li>
                <li class="main-nav__item main-nav__item--dropdown">
                    <a class="main-nav__link" href="#">Каталог</a>
                    <ul class="main-nav__list-sub main-nav__list-sub--closed">
                        <li class="main-nav__item main-nav__item--all"><a class="main-nav__link" href="/catalog.html">Весь
                                каталог</a>
                        <li class="main-nav__item"><a class="main-nav__link" href="/catalog.html">Пряжа</a>
                            <!--   <ul class="main-nav__list-sub">
                                   <li><a class="link main-nav__item" href="#">Акриловая пряжа</a></li>
                                   <li><a class="link main-nav__item" href="#">Бамбуковая пряжа</a></li>
                                   <li><a class="link main-nav__item" href="#">Буклированная пряжа</a></li>
                                   <li><a class="link main-nav__item" href="#">Кажемированная пряжа</a></li>
                                   <li><a class="link main-nav__item" href="#">Ленточная пряжа</a></li>
                                   <li><a class="link main-nav__item" href="#">Пряжа вискоза</a></li>
                               </ul> -->
                        </li>
                        <li class="main-nav__item"><a class="main-nav__link" href="#">Наборы для вязания</a></li>
                        <li class="main-nav__item"><a class="main-nav__link" href="#">Спицы, крючки, инструменты для
                                вязания</a></li>
                        <li class="main-nav__item"><a class="main-nav__link" href="#">Фурнитура</a></li>
                        <li class="main-nav__item"><a class="main-nav__link" href="#">Товары для рукоделия</a></li>
                        <li class="main-nav__item"><a class="main-nav__link" href="#">Литература</a></li>
                    </ul>
                </li>
                <li class="main-nav__item"><a class="main-nav__link" href="#">Доставка</a></li>
                <li class="main-nav__item"><a class="main-nav__link" href="#">Оплата</a></li>
                <li class="main-nav__item"><a class="main-nav__link" href="#">Контакты</a></li>
            </ul>
            <ul class="main-nav__user-list">
                <li class="main-nav__user-item"><a class="main-nav__link" href="#">Войти</a></li>
                <li class="main-nav__user-item"><a class="main-nav__link" href="#">Регистрация</a></li>
            </ul>
            <div class="main-nav__search search">
                <form action="" class="search__form">
                    <div class="search__wrapper">
                        <input type="text" class="search__input" placeholder="Поиск...">
                        <button type="submit" class="search__button">Поиск</button>
                    </div>
                </form>
            </div>
        </div>
    </nav>
</header>
<main class="main__body">
    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
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
            <img src="img/logo-footer.png"/>
        </div>

        <ul class="page-footer__card-payment-list">
            <li><img src="img/mastercard.svg" width="40" height="27" alt="MasterCard"></li>
            <li><img src="img/visa.svg" width="40" height="27" alt="Visa"></li>
        </ul>
    </div>

</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>