<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 03.12.2018
 * Time: 15:01
 */

namespace app\commands;

use app\models\Brand;
use app\models\Category;
use yii\console\Controller;

class ParseExcelController extends Controller
{
    public function actionLoadCategory()
    {

        if(!$this->existExcelFile()) return false;

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
        if(!$this->existExcelFile()) return false;

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

    private function existExcelFile()
    {
        if (file_exists('price.xls')) {
            return \PHPExcel_IOFactory::load('price.xls');
        }
        else {
            echo 'file not exist';
            return false;
        };
    }
}