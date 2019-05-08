<?php


namespace app\components\price;


use core\entities\Shop\Brand;
use app\core\entities\Shop\Category;
use app\models\Good;
use app\modules\trade\models\Price;
use app\modules\trade\models\SetPriceAjaxForm;
use yii\db\Query;

/**
 * Class ParsePriceListCSV
 *
 * @property Good $good
 * @property StringCsv $currentStringCSV
 *
 *
 * @package app\components\price
 */
class ParsePriceListCSV implements ParsePriceListInterface
{
    private $form;
    private $arrayCSVStrings;
    private $currentStringCSV;
    private $good;

    public function __construct(SetPriceAjaxForm $form)
    {
        $this->form = $form;
        $this->arrayCSVStrings = explode(';', $this->form->stringPackCsv);
    }

    public function parse()
    {
        foreach ($this->arrayCSVStrings as $item) {
            $this->currentStringCSV = new StringCsv($item);

            $this->good = $this->findOrCreateGood();

            if ($this->setWholesalePrice()) {
                $this->setRetailPrice();
            };

            $this->setSessionCurrentStep();
        }

        return true;
    }

    private function setWholesalePrice()
    {
        $Price = $this->getPriceToLastDate(Price::TYPE_PRICE_WHOLESALE);

        if (!isset($Price) || $Price->price != $this->currentStringCSV->price) {
            $Price = new Price();
            $Price->date = $this->form->date_set_price;
            $Price->type_price = Price::TYPE_PRICE_WHOLESALE;
            $Price->good_id = $this->good->id;
            $Price->price = $this->currentStringCSV->price;
            $Price->save();

            unset($Price);
            return true;
        }

        unset($Price);
        return false;

    }

    private function setRetailPrice()
    {
        $Price = $this->getPriceToLastDate(Price::TYPE_PRICE_RETAIL);

        $priceRetail = (int)($this->currentStringCSV->price * ($this->form->percent_change / 100 + 1));

        if (!isset($Price) || $Price->price != $priceRetail) {
            $Price = new Price();
            $Price->date = $this->form->date_set_price;
            $Price->type_price = Price::TYPE_PRICE_RETAIL;
            $Price->good_id = $this->good->id;
            $Price->price = $priceRetail;
            $Price->save();

            unset($Price);
            return true;
        }

        unset($Price);
        return false;

    }

    private function getPriceToLastDate($type_price)
    {
        $subQuery = (new Query())->select('MAX(date)')->from('price')->where(['good_id' => $this->good->id, 'type_price' => $type_price]);
        return Price::find()->where(['date' => $subQuery, 'good_id' => $this->good->id, 'type_price' => $type_price])->one();

    }

    private function findOrCreateGood()
    {
        if (Good::findOne(['article' => $this->currentStringCSV->article])) {
            return Good::findOne(['article' => $this->currentStringCSV->article]);
        } else {
            return $this->createGood();
        }
    }


    private function createGood()
    {
        $Good = new Good();
        $Good->name = $this->currentStringCSV->name;
        $Good->article = $this->currentStringCSV->article;
        $Good->characteristic = $this->currentStringCSV->characteristic;
        $Good->packaged = $this->currentStringCSV->package;

        if ($category = Category::findOne(['name' => $this->currentStringCSV->category])) {
            $Good->category_id = $category->id;
        }
        else {
            $Good->category_id = 1;
        }

        if ($brand = Brand::findOne(['name' => $this->currentStringCSV->brand])) {
            $Good->brand_id = $brand->id;
        }
        else {
            $Good->brand_id = 1;
        }

        if ($Good->save()) {
            return $Good;
        };
    }

    private function setSessionCurrentStep()
    {
        $session = \Yii::$app->session;
        $nextNumber = (int)$this->currentStringCSV->number + 1;
        $session->set('countCsv', $nextNumber);
    }

}