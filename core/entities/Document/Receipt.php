<?php

namespace app\core\entities\Document;

use app\modules\trade\models\DocumentInterface;
use app\modules\trade\models\Partner;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class Receipt extends Document implements DocumentInterface
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

    public function getPartner(): ActiveQuery
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    public function getDocumentItems(): ActiveQuery
    {
        return $this->hasMany(ReceiptItem::className(), ['document_id' => 'id'])->orderBy('sort');
    }

    /**
     * @param $documentId
     * @param $goodId
     * @return ReceiptItem
     */
    public function createTableItem($documentId, $goodId)
    {
        $tableItem =  new ReceiptItem();

        $tableItem->document_id = $documentId;
        $tableItem->good_id = $goodId;

        return $tableItem;
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::className(),
                'relations' => ['documentItems'],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
}
