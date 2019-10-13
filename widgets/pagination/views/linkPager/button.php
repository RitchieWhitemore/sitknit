<?php

use yii\helpers\Html;

/**
 * @var $buttonText string
 * @var $dataUrl string
 * @var $itemsClass string
 * @var $countClass string
 * @var $paginatorClass string
 * @var $buttonClass string
 */
?>

<?= Html::tag(
    'button',
    $buttonText,
    [
        'onclick' => 'loadMore(this);',
        'data-url' => $dataUrl,
        'data-items' => $itemsClass,
        'data-count' => $countClass,
        'data-class' => $paginatorClass,
        'class' => $buttonClass,
    ]
) ?>


