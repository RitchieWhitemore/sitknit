<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AdminLtePluginAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;

AdminLtePluginAsset::register($this);
AdminAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="/node_modules/@webcomponents/webcomponentsjs/webcomponents-loader.js"></script>
</head>
<body class="<?= \dmstr\helpers\AdminLteHelper::skinClass() ?>">
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options'         => ['class' => 'navbar-nav navbar-right'],
        'activateParents' => true,
        'items'           => array_filter([
            ['label' => 'Главная', 'url' => ['/main/default/index']],
            ['label' => 'Администрирование пользователей', 'url' => ['/admin/users/index']],
            ['label' => 'Брэнды', 'url' => ['/admin/brands/index']],
            ['label' => 'Категории', 'url' => ['/admin/categories/index']],
            ['label' => 'Страны', 'url' => ['/admin/country/index']],
            ['label' => 'Управление товарами', 'items' => [
                ['label' => 'Товары', 'url' => ['/admin/goods/index']],
                ['label' => 'Атрибуты', 'url' => ['/admin/attributes/index']],
                ['label' => 'Значения атрибута', 'url' => ['/admin/attribute-values/index']],
                ['label' => 'Единицы измерения', 'url' => ['/admin/units/index']],
                ['label' => 'Изображения', 'url' => ['/admin/images/index']],
            ]],
            ['label' => 'Управление ценами', 'items' => [
                ['label' => 'Цены', 'url' => ['/trade/prices/index']],
                ['label' => 'Установить цены', 'url' => ['/trade/prices/set-prices']],
            ]],
            ['label' => 'Документы', 'url' => ['/trade/documents/index']],

        ]),
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
