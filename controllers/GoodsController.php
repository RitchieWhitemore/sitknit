<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 03.01.2019
 * Time: 22:22
 */

namespace app\controllers;

use app\core\entities\Shop\Brand;
use app\core\entities\Shop\Category;
use app\core\entities\Shop\Good\Good;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class GoodsController extends Controller
{
    public function actionCatalog()
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => Category::find()->where(['active' => 1])->andWhere(['parent_id' => null]),
            ]
        );
        return $this->render('catalog', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCategory($id)
    {
        $Category = Category::findOne($id);

        if (!isset($Category)) {
            throw new NotFoundHttpException();
        }

        $subcategories = new ActiveDataProvider(
            [
                'query' => Category::find()->active()->andWhere(['parent_id' => $id]),
            ]
        );

        $dataProvider = new ActiveDataProvider(
            [
                'query' => Good::find()->where(['category_id' => $id, 'active' => 1])->with(['attributeValues', 'mainGood.attributeValues']),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]
        );

        if ($Category->parent == null) {
            $childrenCategory = (new Query())->from('category')->where(['parent_id' => $id])->column();
            $childrenCategory[] = 1;

            $queryBrands =  Good::find()->select(['id', 'brand_id'])->where(['active'=> 1])->andWhere(['in', 'category_id', $childrenCategory])->groupBy('brand_id');

        } else {
            $queryBrands = null;
        }

        $brands = new ActiveDataProvider(
            [
                'query' => $queryBrands,
            ]
        );

        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'subcategories' => $subcategories,
            'model' => $Category,
            'brands' => $brands,
        ]);
    }

    public function actionBrand($id, $name = '')
    {
        $Brand = Brand::find()->joinWith(['goods'])->where(['brand.id' => $id, 'good.active' => 1])->one();

        $goodsByNameDataProvider = new ActiveDataProvider(
          [
              'query' => $Brand->getGoods()->active()->groupBy('name'),
          ]
        );

        $goodsDataProvider = new ActiveDataProvider(
            [
                'query' => $Brand->getGoods()->where(['like', 'name', $name])->active(),
            ]
        );

        return $this->render('brand', [
            'goodsByNameDataProvider' => $goodsByNameDataProvider,
            'goodsDataProvider' => $goodsDataProvider,
            'brand' => $Brand,
        ]);
    }

    public function actionView($id)
    {
        $model = Good::find()->where(['id' => $id, 'active' => 1])->with(['attributeValues'])->one();

        if (!$model) {
            throw new NotFoundHttpException();
        }

        if (isset($model->mainGood)) {
            $valuesMain = $model->mainGood->getAttributeValues()->with('goodAttribute.unit')->indexBy('goodAttribute.name')->all();
            $values = $model->getAttributeValues()->with('goodAttribute.unit')->indexBy('goodAttribute.name')->all();
        } else {
            $values = $model->getAttributeValues()->with('goodAttribute.unit')->indexBy('goodAttribute.name')->all();
            $valuesMain = $values;
        }


        return $this->render('good', [
            'model' => $model,
            'values' => $values,
            'valuesMain' => $valuesMain,
        ]);
    }
}