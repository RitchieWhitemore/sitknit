<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 18.02.2019
 * Time: 16:32
 */

namespace app\components;


use app\core\entities\Shop\Category;
use app\core\entities\Shop\Price;
use app\models\Good;
use app\modules\trade\models\SetPriceAjaxForm;
use core\entities\Shop\Brand;
use yii\db\Query;

class SetPrice
{
    const PERCENT_CHANGE = 30;
    private $date_set_price;
    private $filePath;
    private $file;
    private $fileExtension;
    private $good;
    private $priceWholesale;
    private $form;

    public function __construct(SetPriceAjaxForm $form)
    {
        $this->form = $form;

        if (isset($form->file_price)) {
            if ($form->file_price->tempName === 'temp/price.xls') {
                $this->filePath = 'temp/price.xls';
                $this->file = $form->file_price;
                $this->fileExtension = $this->getFileExtension($this->filePath);
            }
            else {
                $this->file = $form->file_price;
                $this->filePath = $form->file_price->tempName;
                $this->fileExtension = $this->getFileExtension($this->file->name);
            }
        } else {
            $this->fileExtension = 'string';
        }

    }

    public function run()
    {
        set_time_limit(300);
        switch ($this->fileExtension) {
            case 'xls':
                $this->parseFileExcel();
                break;
            case 'csv':
                $this->parseFileCSV();
                break;
            case 'string':
                $this->parsePackCSV();
                break;
        }
        return true;
    }

    private function parsePackCSV()
    {
        $array = explode(';', $this->form->stringCsv);

        $session = \Yii::$app->session;
        $currentCount = $session->get('countCsv');
        $session->set('countCsv', (count($array) + $currentCount));

        foreach ($array as $key => $item) {
            $value = explode('|', $item);
            $this->priceWholesale = str_replace(',', '.', $value[8]);

            if (Good::findOne(['article' => $value[1]])) {
                $this->good = Good::findOne(['article' => $value[1]]);

                if ($this->setWholesalePrice()) {
                    $this->setRetailPrice();
                };

            }
            else {
                $this->createGood($value);

                if ($this->setWholesalePrice()) {
                    $this->setRetailPrice();
                };
            }
        }

    }

    private function parseFileCSV()
    {
        $row = 1;
        if (($handle = fopen($this->filePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if ($row > 1) {

                    foreach ($data as $key => $value) {
                        $data[$key] = iconv("WINDOWS-1251", "UTF-8", $value);
                    }

                    $this->priceWholesale = str_replace(',', '.', $data[8]);

                    if (Good::findOne(['article' => $data[1]])) {
                        $this->good = Good::findOne(['article' => $data[1]]);

                        if ($this->setWholesalePrice()) {
                            $this->setRetailPrice();
                        };

                    }
                    else {
                        $this->createGood($data);

                        if ($this->setWholesalePrice()) {
                            $this->setRetailPrice();
                        };
                    }
                }
                $row++;
            }
            fclose($handle);
        }
    }

    private function parseFileExcel()
    {

        /**
         *
         * Существуют проблемы с памятью, при работе этого метода
         * Также есть момент, если сразу распарсить скачаный файл с http://www.kudel.ru/reklama/price.xls,
         * то возникает ошибка "Uninitialized string offset: 10". Если этот файл открыть и сохранить, то ошибки не будет.
         *
         */

        //if (!$excelFile = $this->getExcelFile()) return false;

        $chunkSize = 1000;
        $chunkFilter = new ChunkReadFilter();

        /**  Loop to read our worksheet in "chunk size" blocks  **/
        for ($startRow = 2; $startRow <= 65536; $startRow += $chunkSize) {
            /**  Tell the Read Filter which rows we want this iteration  **/
            $chunkFilter->setRows($startRow, $chunkSize);

            $reader = $this->getReader();
            $reader->setReadFilter($chunkFilter);
            /**  Load only the rows that match our filter  **/
            $excelFile = $reader->load($this->filePath);
            //    Do some processing here
            $highestRow = $excelFile->getActiveSheet()->getHighestRow();
            if ($highestRow < $startRow) {
                break;
            }
            $rowIterator = $excelFile->getActiveSheet()->getRowIterator($startRow, $chunkSize);

            foreach ($rowIterator as $row) {
                $cellIterator = $row->getCellIterator();
                $col = ['idx' => $row->getRowIndex()];
                foreach ($cellIterator as $key => $cell)
                    $col[$key] = $cell->getCalculatedValue();

                $this->priceWholesale = str_replace(',', '.', $col['I']);

                if (Good::findOne(['article' => $col['B']])) {
                    $this->good = Good::findOne(['article' => $col['B']]);

                    if ($this->setWholesalePrice()) {
                        $this->setRetailPrice();
                    };

                }
                else {
                    $this->createGood($col);

                    if ($this->setWholesalePrice()) {
                        $this->setRetailPrice();
                    };
                }


            }

            unset($excelFile);
            unset($reader);
        }


        return true;
    }

    private function setWholesalePrice()
    {
        $Price = $this->getPrice(Price::TYPE_PRICE_WHOLESALE);

        if (isset($Price)) {
            if ($Price->price != $this->priceWholesale) {
                $Price = new Price();
                $Price->date = $this->form->date_set_price;
                $Price->type_price = Price::TYPE_PRICE_WHOLESALE;
                $Price->good_id = $this->good->id;
                $Price->price = $this->priceWholesale;
                $Price->save();
            }
            else {
                unset($Price);
                return false;
            }
        }
        else {
            $Price = new Price();
            $Price->date = $this->form->date_set_price;
            $Price->type_price = Price::TYPE_PRICE_WHOLESALE;
            $Price->good_id = $this->good->id;
            $Price->price = $this->priceWholesale;
            $Price->save();
        }
        unset($Price);
        return true;

    }

    private function setRetailPrice()
    {
        $Price = $this->getPrice(Price::TYPE_PRICE_RETAIL);

        $priceRetail = (int)($this->priceWholesale * ($this->form->percent_change / 100 + 1));

        if (isset($Price)) {
            if ($Price->price != $priceRetail) {
                $Price = new Price();
                $Price->date = $this->form->date_set_price;
                $Price->type_price = Price::TYPE_PRICE_RETAIL;
                $Price->good_id = $this->good->id;
                $Price->price = $priceRetail;
                $Price->save();
            }
            else {
                unset($Price);
                return false;
            }
        }
        else {
            $Price = new Price();
            $Price->date = $this->form->date_set_price;
            $Price->type_price = Price::TYPE_PRICE_RETAIL;
            $Price->good_id = $this->good->id;
            $Price->price = $priceRetail;
            $Price->save();
        }
        unset($Price);
        return true;
    }

    private function getPrice($type_price)
    {
        $subQuery = (new Query())->select('MAX(date)')->from('price')->where(['good_id' => $this->good->id, 'type_price' => $type_price]);
        return Price::find()->where(['date' => $subQuery, 'good_id' => $this->good->id, 'type_price' => $type_price])->one();

    }

    private function getExcelFile()
    {
        if (file_exists($this->file)) {
            return true;
        }
        else {
            echo 'file not exist';
            return false;
        }
    }

    private function getReader()
    {

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();

        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);
        $reader->setLoadSheetsOnly('Goods list table');

        return $reader;
    }

    private function getFileExtension($name)
    {
        $nameArr = explode('.', $name);
        return array_pop($nameArr);
    }

    private function createGood($data)
    {
        $Good = new Good();
        $Good->name = isset($data['E']) ? $data['E'] : $data['4'];
        $Good->article = isset($data['B']) ? $data['B'] : $data['1'];
        $Good->characteristic = isset($data['F']) ? $data['F'] : $data['5'];
        $Good->packaged = isset($data['J']) ? $data['J'] : $data['9'];

        if ($category = Category::findOne(['name' => isset($data['C']) ? $data['C'] : $data['2']])) {
            $Good->category_id = $category->id;
        }
        else {
            $Good->category_id = 1;
        }

        if ($brand = Brand::findOne(['name' => isset($data['D']) ? $data['D'] : $data['3']])) {
            $Good->brand_id = $brand->id;
        }
        else {
            $Good->brand_id = 1;
        }

        if ($Good->save()) {
            $this->good = $Good;
           // echo "Good {$Good->name} article {$Good->article} success added" . PHP_EOL;
        };
    }


}