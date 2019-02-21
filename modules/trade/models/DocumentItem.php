<?php

namespace app\modules\trade\models;

use app\models\Good;


/**
 * This is the model class for table "document_item".
 *
 * @property int $id
 * @property int $document_id
 * @property int $good_id
 * @property int $qty
 * @property double $price
 *
 * @property Document $document
 * @property Good $good
 */
class DocumentItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document_id', 'good_id', 'qty', 'price'], 'required'],
            [['document_id', 'good_id', 'qty'], 'integer'],
            [['price'], 'number'],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => Document::className(), 'targetAttribute' => ['document_id' => 'id']],
            [['good_id'], 'exist', 'skipOnError' => true, 'targetClass' => Good::className(), 'targetAttribute' => ['good_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'document_id' => 'Документ',
            'good_id' => 'Товар',
            'qty' => 'Количество',
            'price' => 'Цена',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument()
    {
        return $this->hasOne(Document::className(), ['id' => 'document_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }
}
