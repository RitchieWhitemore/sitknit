<?php

namespace app\core\entities\Document;

use app\core\behaviors\TagDependencyBehavior;
use app\core\entities\Shop\Good\Good;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "receipt_item".
 *
 * @property int     $document_id
 * @property int     $good_id
 * @property int     $qty
 * @property double  $price
 * @property double  $sum
 * @property integer $sort
 *
 * @property Good    $good
 * @property Receipt $document
 */
class ReceiptItem extends ActiveRecord
{
    /**
     * @var integer
     */
    public $totalQty;

    public function behaviors()
    {
        return [
            'TagDependencyBehavior' => TagDependencyBehavior::class,
        ];
    }

    public static function create($documentId, $goodId, $qty, $price): self
    {
        $item = new static();
        $item->document_id = $documentId;
        $item->good_id = $goodId;
        $item->qty = $qty;
        $item->price = $price;

        return $item;
    }

    public function edit($goodId, $qty, $price)
    {
        $this->good_id = $goodId;
        $this->qty = $qty;
        $this->price = $price;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo($documentId, $goodId): bool
    {
        return $this->document_id == $documentId && $this->good_id == $goodId;
    }

    public function beforeSave($insert)
    {
        $this->sum = $this->price * $this->qty;
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receipt_item';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'document_id' => 'Приход №',
            'good_id'     => 'Товар',
            'qty'         => 'Количество',
            'price'       => 'Цена',
            'sum'         => 'Сумма'
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['article'] = function () {
            return $this->good->article;
        };
        $fields['article'] = function () {
            return $this->good->article;
        };
        $fields['nameAndColor'] = function () {
            return $this->good->getNameAndColor();
        };


        //unset($fields['good_id']);
        return $fields;
    }

    public function getGood(): ActiveQuery
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }

    public function getDocument(): ActiveQuery
    {
        return $this->hasOne(Receipt::className(), ['id' => 'document_id']);
    }
}
