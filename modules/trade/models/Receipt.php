<?php

namespace app\modules\trade\models;

/**
 * This is the model class for table "receipt".
 *
 * @property int $id
 * @property string $date
 * @property int $partner_id
 * @property double $total
 *
 * @property Partner $partner
 * @property ReceiptItem[] $documentItems
 */
class Receipt extends \yii\db\ActiveRecord implements DocumentInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receipt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'partner_id'], 'required'],
            [['date'], 'safe'],
            [['partner_id'], 'integer'],
            [['total'], 'number'],
            [['partner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partner::className(), 'targetAttribute' => ['partner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'partner_id' => 'Контрагент',
            'total' => 'Сумма',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentItems()
    {
        return $this->hasMany(ReceiptItem::className(), ['receipt_id' => 'id']);
    }

    /**
     * @param $documentId
     * @param $goodId
     * @return ReceiptItem
     */
    public function createTableItem($documentId, $goodId)
    {
        $tableItem =  new ReceiptItem();

        $tableItem->receipt_id = $documentId;
        $tableItem->good_id = $goodId;

        return $tableItem;
    }
}
