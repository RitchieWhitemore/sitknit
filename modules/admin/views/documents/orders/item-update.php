<?php


/* @var $this yii\web\View */
/* @var $item app\core\entities\Document\ReceiptItem */
/* @var $documentTableForm app\core\forms\manage\Document\ReceiptItemForm */

$this->title = 'Редактировать строку ' . $item->sort . ' заказа покупателя: №' . $item->document_id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы покупателей', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => 'Заказ покупателя № ' . $item->document_id,
    'url'   => ['view', 'id' => $item->document_id]
];
$this->params['breadcrumbs'][] = 'Редактировать';

?>
<div class="order-item-update">

    <?= $this->render('_form-item', [
        'document'           => $item->document,
        'documentItem'      => $item,
        'documentTableForm' => $documentTableForm
    ]) ?>

</div>
