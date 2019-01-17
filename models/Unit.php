<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property string $name
 * @property string $full_name
 *
 * @property Attribute[] $attributes0
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 10],
            [['full_name'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Краткое наименование',
            'full_name' => 'Полное наименование',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoodAttributes()
    {
        return $this->hasMany(Attribute::className(), ['unit_id' => 'id']);
    }
}
