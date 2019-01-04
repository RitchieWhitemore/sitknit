<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
            [['active'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
            'active' => 'Активен',
        ];
    }

    public static function getCategoriesArray()
    {
        return self::find()->select(['title','id'])->indexBy('id')->column();
    }

    public function getGoods()
    {
        return $this->hasMany(Good::className(), ['categoryId' => 'id']);
    }
}
