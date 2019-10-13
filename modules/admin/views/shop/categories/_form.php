<?php

use app\core\entities\Shop\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\core\entities\Shop\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'parentId')->dropDownList($model->parentCategoriesList()) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

            <?= $form->field($model, 'content')->textarea() ?>

            <?= $form->field($model, 'status')->dropDownList(Category::getStatusList(),
                ['prompt' => 'активируйте категорию']) ?>

            <?php
            if (isset($category->image)) {
                echo Html::a(
                    Html::img($category->getThumbFileUrl('image', 'admin')),
                    $category->getUploadedFileUrl('image'),
                    ['class' => 'thumbnail', 'target' => '_blank']
                );
            } else {
                echo Html::img('/img/no-image.svg', ['width' => 200, 'style' => 'margin-bottom: 25px']);
            }
            ?>

            <?= $form->field($model, 'imageFile')->fileInput(['accept' => '.jpg, .jpeg, .png']) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
