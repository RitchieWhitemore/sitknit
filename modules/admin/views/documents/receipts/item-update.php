<?php


/* @var $this yii\web\View */
/* @var $item app\core\entities\Document\ReceiptItem */
/* @var $documentTableForm app\core\forms\manage\Document\ReceiptItemForm */

$this->title = 'Редактировать строку ' . $item->sort . ' поступления товара: №' . $item->document_id;
$this->params['breadcrumbs'][] = ['label' => 'Поступления', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => 'Поступление товара № ' . $item->document_id,
    'url'   => ['view', 'id' => $item->document_id]
];
$this->params['breadcrumbs'][] = 'Редактировать';

?>
<div class="receipt-item-update">

    <?= $this->render('_form-item', [
        'receipt'           => $item->document,
        'documentItem'      => $item,
        'documentTableForm' => $documentTableForm
    ]) ?>

</div>
