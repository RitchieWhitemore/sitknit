<?php

namespace app\core\entities\Document;

use app\core\behaviors\TagDependencyBehavior;
use app\core\entities\Shop\Good\Good;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_item".
 *
 * @property int $document_id
 * @property int $good_id
 * @property int $qty
 * @property double $price
 * @property double $sum
 * @property integer $sort
 *
 * @property Good $good
 * @property Order $document
 */
class OrderItem extends ActiveRecord
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TagDependencyBehavior' => [
                'class' => TagDependencyBehavior::class,
            ],
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

    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'document_id' => 'Заказ №',
            'good_id' => 'Товар',
            'qty' => 'Количество',
            'price' => 'Цена',
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
        return $this->hasOne(Order::className(), ['id' => 'document_id']);
    }
}
