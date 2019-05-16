<?php


namespace app\controllers;


use app\core\readModels\Shop\BrandReadRepository;
use app\core\readModels\Shop\CategoryReadRepository;
use app\core\readModels\Shop\GoodReadRepository;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CatalogController extends Controller
{
    private $goods;
    private $categories;
    private $brands;

    public function __construct(
        $id,
        $module,
        GoodReadRepository $goods,
        CategoryReadRepository $categories,
        BrandReadRepository $brands,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->goods = $goods;
        $this->categories = $categories;
        $this->brands = $brands;
    }

    public function actionIndex()
    {
        $dataProvider = $this->categories->getCategoriesInRoot();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCategory($id)
    {
        if (!$category = $this->categories->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $dataProvider = $this->goods->getAllByCategory($category);

        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionBrand($id)
    {
        if (!$brand = $this->brands->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $dataProvider = $this->goods->getAllByBrand($brand);
        return $this->render('brand', [
            'brand' => $brand,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionGood($id)
    {
        if (!$good = $this->goods->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (isset($good->mainGood)) {
            $valuesMain = $good->mainGood->getValues()->with('characteristic.unit')->indexBy('characteristic.name')->all();
            $values = $good->getValues()->with('characteristic.unit')->indexBy('characteristic.name')->all();
        } else {
            $values = $good->getValues()->with('characteristic.unit')->indexBy('characteristic.name')->all();
            $valuesMain = $values;
        }

        return $this->render('good', [
            'good' => $good,
            'values' => $values,
            'valuesMain' => $valuesMain,
        ]);
    }
}