<?php

use yii\helpers\Html;
use yii\helpers\Url;

\app\modules\cart\widgets\assets\CartFormAsset::register($this);
?>

<?php $form = \yii\widgets\ActiveForm::begin([
    'action' => Url::to(['/cart/default/add']),
    'method' => 'post',
    'options' => [
        'class' => 'page-product__qty-form',
    ],
])
?>

<div class="page-product__qty qty">
    <?= Html::activeHiddenInput($model, 'goodId') ?>
    <?= Html::activeInput('number', $model, 'qty', ['class' => 'qty__input', 'placeholder' => '0', 'min' => 0]) ?>
    <button type="button" class="qty__minus">-</button>
    <button type="button" class="qty__plus">+</button>
</div>
<span class="page-product__unit">шт.</span>
<button type="submit" class="page-product__cart">В корзину</button>
<?php \yii\widgets\ActiveForm::end() ?>
