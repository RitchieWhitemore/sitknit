<?php


namespace app\components\price;


use app\core\entities\Shop\Brand;
use app\core\entities\Shop\Category;
use app\core\entities\Shop\Good\Good;
use app\core\entities\Shop\Price;
use app\core\repositories\Shop\PriceRepository;
use app\modules\trade\models\SetPriceAjaxForm;


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
    private $priceRepository;

    public function __construct(SetPriceAjaxForm $form, PriceRepository $priceRepository)
    {
        $this->form = $form;
        $this->arrayCSVStrings = explode(';', $this->form->stringPackCsv);
        $this->priceRepository = $priceRepository;
    }

    public function parse()
    {
        foreach ($this->arrayCSVStrings as $item) {
            $this->currentStringCSV = new StringCsv($item);

            $this->good = $this->findOrCreateGood();

            $this->setWholesalePrice();
            $this->setRetailPrice();

            $this->setSessionCurrentStep();
        }

        return true;
    }

    private function setWholesalePrice()
    {
        $price = $this->priceRepository->getPriceToLastDate(Price::TYPE_PRICE_WHOLESALE, $this->good->id);

        if (!isset($price) || $price->price != $this->currentStringCSV->price) {
            $price = new Price();
            $price->date = $this->form->date_set_price;
            $price->type_price = Price::TYPE_PRICE_WHOLESALE;
            $price->good_id = $this->good->id;
            $price->price = $this->currentStringCSV->price;
            $price->save();

            unset($price);
            return true;
        }

        unset($price);
        return false;

    }

    private function setRetailPrice()
    {
        $price = $this->priceRepository->getPriceToLastDate(Price::TYPE_PRICE_RETAIL, $this->good->id);

        $percent = isset($this->good->mainGood) && $this->good->mainGood->percent > 0 ? $this->good->mainGood->percent : $this->form->percent_change;

        $priceRetail = (int)($this->currentStringCSV->price * ($percent / 100 + 1));

        if (!isset($price) || $price->price != $priceRetail) {
            $price = new Price();
            $price->date = $this->form->date_set_price;
            $price->type_price = Price::TYPE_PRICE_RETAIL;
            $price->good_id = $this->good->id;
            $price->price = $priceRetail;
            $price->save();

            unset($price);
            return true;
        }

        unset($price);
        return false;

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
        } else {
            $Good->category_id = 1;
        }

        if ($brand = Brand::findOne(['name' => $this->currentStringCSV->brand])) {
            $Good->brand_id = $brand->id;
        } else {
            $Good->brand_id = 1;
        }

        if ($Good->save()) {
            return $Good;
        };
    }

    private function setSessionCurrentStep()
    {
        $session = \Yii::$app->session;

        $nextNumber = (int)$session->get('countCsv') + 1;
        $session->set('countCsv', $nextNumber);
    }

}