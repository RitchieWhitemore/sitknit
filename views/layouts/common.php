<?php

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 */

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?= Html::csrfMetaTags() ?>
        <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&amp;subset=cyrillic" rel="stylesheet">
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

    </head>
    <body>
    <?php $this->beginBody() ?>
    <?= $this->render('parts/header') ?>
    <main class="main__body">
        <div class="container">
            <section class="main__content">
                <div class="main__page-content">
                    <div class="alert__wrapper">
                        <?= Alert::widget() ?>
                    </div>
                    <?= $content ?>
                </div>
            </section>
        </div>
    </main>
    <?= $this->render('parts/footer') ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>