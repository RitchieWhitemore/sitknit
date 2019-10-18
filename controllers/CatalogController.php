<?php


namespace app\controllers;


use app\core\entities\Shop\Good\search\GoodFilterSearch;
use app\core\readModels\Shop\BrandReadRepository;
use app\core\readModels\Shop\CategoryReadRepository;
use app\core\readModels\Shop\GoodReadRepository;
use app\widgets\pagination\LinkPager;
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
    ) {
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
     * @param $slug
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCategory($slug)
    {
        if (!$category = $this->categories->findBySlug($slug)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        /*  if ($category->isYarn()) {
              $composition = Category::find()->isComposition()->one();
              $categories = Category::find()->active()->all();
              $compositions = [];
              foreach ($categories as $item) {
                  if ($item->isChildOf($composition)) {
                      $compositions[] = $item;
                  }
              }
              return $this->render('yarn', [
                  'compositions' => $compositions,
                  'category' => $category
              ]);
          }*/

        $searchModel = new GoodFilterSearch([
            'category_id' => $category->id,
        ]);
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        if (\Yii::$app->request->isAjax) {
            return $this->asJson(LinkPager::getPageItems($dataProvider, $this));
        }

        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $dataProvider,
            'list' => $dataProvider->getModels(),
            'pagination' => $dataProvider->getPagination(),
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

        $otherColors = $this->goods->getOtherColors($good);

        return $this->render('good', [
            'good' => $good,
            'values' => $values,
            'valuesMain' => $valuesMain,
            'otherColors' => $otherColors,
        ]);
    }
}