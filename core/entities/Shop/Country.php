<?php

namespace app\core\entities\Shop;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class Country extends ActiveRecord
{

    public static function create($name, $description): self
    {
        $country = new static();
        $country->name = $name;
        $country->description = $description;

        return $country;
    }

    public function edit($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%country}}';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
        ];
    }

    public static function getCountryArray()
    {
        return self::find()->select(['name','id'])->indexBy('id')->column();
    }
}
