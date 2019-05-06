<?php

/* @var $this yii\web\View */
/* @var $country app\core\entities\Shop\Country */
/* @var $model app\core\forms\manage\Shop\CountryForm */

$this->title = 'Редактировать страну: ' . $country->name;
$this->params['breadcrumbs'][] = ['label' => 'Страны', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $country->name, 'url' => ['view', 'id' => $country->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="country-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
