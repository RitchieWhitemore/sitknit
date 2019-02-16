<?php

namespace app\modules\trade\models;

use Yii;

/**
 * This is the model class for table "document".
 *
 * @property int $id
 * @property string $date
 * @property int $type_id
 * @property double $total
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'type_id'], 'required'],
            [['date'], 'safe'],
            [['type_id'], 'integer'],
            [['total'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'type_id' => 'Type ID',
            'total' => 'Total',
        ];
    }
}
