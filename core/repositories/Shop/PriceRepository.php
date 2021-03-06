<?php


namespace app\core\repositories\Shop;


use app\core\entities\Shop\Price;
use app\core\forms\manage\Shop\PriceForm;
use app\core\repositories\NotFoundException;
use yii\db\Query;

class PriceRepository
{
    public function get($id): Price
    {
        if (!$price = Price::findOne($id)) {
            throw new NotFoundException('Price is not found.');
        }
        return $price;
    }

    public function existsPrice(PriceForm $form): bool
    {
        if ($model = Price::find()
            ->where([
                'type_price' => $form->type_price,
                'price'      => $form->price,
                'good_id'    => $form->good_id
            ])
            ->andWhere(['<=', 'date', $form->date])
            ->orderBy(['date' => SORT_DESC])
            ->limit(1)
            ->one()
        ) {
            return true;
        }
        return false;
    }

    public function findPriceOnDate(PriceForm $form)
    {
        $price = Price::find()
            ->where([
                'type_price' => $form->type_price,
                'good_id'    => $form->good_id
            ])
            ->andWhere(['=', 'date', $form->date])
            ->one();

        return $price;
    }

    public function save(Price $price)
    {
        if (!$price->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Price $price)
    {
        if (!$price->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    public function getPriceToLastDate($type_price, $goodId)
    {
        $subQuery = (new Query())->select('MAX(date)')->from('price')->where([
            'good_id' => $goodId,
            'type_price' => $type_price
        ]);
        return Price::find()->where([
            'date' => $subQuery,
            'good_id' => $goodId,
            'type_price' => $type_price
        ])->orderBy(['id' => SORT_DESC])->limit(1)->one();

    }
}