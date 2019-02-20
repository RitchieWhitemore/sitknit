<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 03.12.2018
 * Time: 15:01
 */

namespace app\commands;

use app\components\SetPrice;
use app\models\Brand;
use app\models\Category;
use app\models\Good;
use app\modules\trade\models\Price;
use igogo5yo\uploadfromurl\UploadFromUrl;
use yii\console\Controller;

class ParseExcelController extends Controller
{
    public function actionLoadCategory()
    {

        if (!$this->existExcelFile()) return false;

        $excelFile = $this->existExcelFile();
        $list = $excelFile->getSheetByName('Goods list table')->toArray();

        foreach ($list as $key => $row) {
            $categoryTitle = $row[2];
            if ($key > 0) {
                if (!Category::findOne(['title' => $categoryTitle])) {
                    $Category = new Category();
                    $Category->title = $categoryTitle;
                    $Category->save();
                }

            }

        }

        return true;
    }

    public function actionLoadBrand()
    {
        if (!$this->existExcelFile()) return false;

        $excelFile = $this->existExcelFile();
        $list = $excelFile->getSheetByName('Goods list table')->toArray();

        foreach ($list as $key => $row) {
            $brandTitle = $row[3];
            if ($key > 0) {
                if (!Brand::findOne(['title' => $brandTitle])) {
                    $Brand = new Brand();
                    $Brand->title = $brandTitle;
                    $Brand->save();
                }

            }

        }

        return true;
    }

    public function actionLoadGood()
    {
        if (!$excelFile = $this->existExcelFile()) return false;

        $list = $excelFile->getSheetByName('Goods list table')->toArray();

        foreach ($list as $key => $row) {
            $goodTitle = $row[4];
            if ($key > 0) {
                if (!Good::findOne(['article' => $row[1]])) {
                    $Good = new Good();
                    $Good->title = $goodTitle;
                    $Good->article = $row[1];
                    $Good->characteristic = $row[5];
                    $Good->packaged = $row[9];

                    if ($category = Category::findOne(['title' => $row[2]])) {
                        $Good->categoryId = $category->id;
                    }
                    else {
                        $Good->categoryId = 1;
                    }

                    if ($brand = Brand::findOne(['title' => $row[3]])) {
                        $Good->brandId = $brand->id;
                    }
                    else {
                        $Good->brandId = 1;
                    }

                    $Good->countryId = 1;

                    if ($Good->save()) {
                        echo "Товар {$Good->title} с артикулом {$Good->article} успешно добавлен" . PHP_EOL;
                    };
                }
                else {
                    echo "Товар с артикулом {$row[1]} уже есть в базе" . PHP_EOL;
                }

            }

        }

        return true;
    }

    public function actionSetPrice()
    {
        $url = 'http://www.kudel.ru/reklama/price.xls';
        $path = 'temp/price.xls';

        $file = UploadFromUrl::initWithUrl($url);
        $file->saveAs($path);

        $setPrice = new SetPrice('temp/price.xls');
        $setPrice->run();
    }
}