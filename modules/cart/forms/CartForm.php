<?php


namespace app\modules\cart\forms;


use yii\base\Model;

class CartForm extends Model
{
    public $goodId;
    public $qty;

    public function rules()
    {
        return [
            [['qty', 'goodId'], 'integer'],
        ];
    }
}