<?php
use yii\helpers\Url;
$name = Yii::$app->request->get('name');
?>
<a href="<?=Url::to(['goods/brand', 'id' => $model->brand->id, 'name' => $model->name])?>"
   class="good-by-name__link <?= ($model->name == $name) ? 'good-by-name__link--active' : '' ?>">
    <?= $model->name ?>
</a>