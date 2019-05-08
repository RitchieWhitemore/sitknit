<?php

namespace app\models;

use app\core\behaviors\UploadImageBehavior;
use Yii;

/**
 * This is the model class for table "composition".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $active
 * @property string $image
 * @property string $content
 *
 * @property Good[] $goods
 */
class Composition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'composition';
    }

    /*public function behaviors()
    {
        return [
            [
                'class' => UploadImageBehavior::className(),
                'fileNameField' => 'image',
                'goodIdField' => 'id',
                'catalog' => 'composition',
            ],
        ];
    }*/

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['active'], 'integer'],
            [['content'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['description', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'description' => 'Краткое описание',
            'active' => 'Активен',
            'image' => 'Изображение',
            'content' => 'Полное описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasMany(Good::className(), ['composition_id' => 'id']);
    }

    public static function getCompositionsArray()
    {
        return self::find()->select(['name', 'id'])->indexBy('id')->column();
    }
}
