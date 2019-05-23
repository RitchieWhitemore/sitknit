<?php

namespace app\core\entities\Document;

use app\modules\trade\models\DocumentInterface;
use app\modules\trade\models\Partner;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $date
 * @property int $status
 * @property int $payment
 * @property int $partner_id
 * @property double $total
 *
 * @property Partner $partner
 * @property OrderItem[] $documentItems
 */
class Order extends \yii\db\ActiveRecord implements DocumentInterface
{
    const STATUS_NOT_RESERVE = 0;
    const STATUS_RESERVE = 1;
    const STATUS_SHIPPED = 2;

    const PAYMENT_NOT_PAYMENT = 0;
    const PAYMENT_PAYMENT = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'partner_id'], 'required'],
            [['date'], 'safe'],
            [['status', 'partner_id', 'payment'], 'integer'],
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
            'status' => 'Статус',
            'payment' => 'Оплата',
            'partner_id' => 'Контрагент',
            'total' => 'Сумма',
        ];
    }

    public function moveItemUp($documentId, $goodId)
    {
        $items = $this->documentItems;
        foreach ($items as $i => $item) {
            if ($item->isIdEqualTo($documentId, $goodId)) {
                if ($prev = $items[$i - 1] ?? null) {
                    $items[$i - 1] = $item;
                    $items[$i] = $prev;
                    $this->updateItems($items);
                }
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    public function moveItemDown($documentId, $goodId)
    {
        $items = $this->documentItems;
        foreach ($items as $i => $item) {
            if ($item->isIdEqualTo($documentId, $goodId)) {
                if ($next = $items[$i + 1] ?? null) {
                    $items[$i] = $next;
                    $items[$i + 1] = $item;
                    $this->updateItems($items);
                }
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    public function calculateTotalSum()
    {
        return $this->getDocumentItems()->sum('sum');
    }

    public function getPartner(): ActiveQuery
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    public function getDocumentItems(): ActiveQuery
    {
        return $this->hasMany(OrderItem::className(), ['document_id' => 'id'])->orderBy('sort');
    }

    /**
     * @param $documentId
     * @param $goodId
     * @return OrderItem
     */
    public function createTableItem($documentId, $goodId)
    {
        $tableItem =  new OrderItem();

        $tableItem->document_id = $documentId;
        $tableItem->good_id = $goodId;

        return $tableItem;
    }

    public function getStatusesArray()
    {
        return [
            self::STATUS_NOT_RESERVE => 'Ожидает подтверждения',
            self::STATUS_RESERVE => 'В резерве',
            self::STATUS_SHIPPED => 'Отгружен',
        ];
    }

    public function getPaymentsArray()
    {
        return [
            self::PAYMENT_NOT_PAYMENT => 'Не оплачен',
            self::PAYMENT_PAYMENT => 'Оплачен',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    public function getPaymentName()
    {
        return ArrayHelper::getValue(self::getPaymentsArray(), $this->payment);
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


    private function updateItems(array $items)
    {
        foreach ($items as $i => $item) {
            $item->setSort($i);
        }
        $this->documentItems = $items;
    }
}
