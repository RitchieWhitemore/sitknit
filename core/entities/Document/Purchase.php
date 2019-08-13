<?php

namespace app\core\entities\Document;

/**
 * This is the model class for table "purchase".
 *
 * @property int $id
 * @property string $date_start
 */
class Purchase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_start'], 'required'],
            [['date_start'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_start' => 'Дата начала закупки',
        ];
    }

    public function nextPurchaseDate()
    {
        $dates = Purchase::find()->select(['date_start'])->orderBy(['date_start' => SORT_ASC])->column();

        $key = array_search($this->date_start, $dates);

        if (isset($dates[++$key])) {
            return $dates[$key];
        }

        return null;
    }
}
