<?php

namespace app\modules\admin\controllers\shop;

use app\core\entities\Shop\Good\Good;
use app\core\forms\manage\Shop\Good\GoodForm;
use app\core\forms\manage\Shop\Good\ImagesForm;
use app\core\services\manage\Shop\GoodManageService;
use app\models\Attribute;
use app\models\AttributeValue;
use Yii;
use app\modules\admin\forms\GoodSearch;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsController implements the CRUD actions for Good model.
 */
class GoodsController extends Controller
{
    private $service;

    public function __construct($id, $module, GoodManageService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-photo' => ['POST'],
                    'move-photo-up' => ['POST'],
                    'move-photo-down' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Good models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Good model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $good = $this->findModel($id);

        /* $index = Good::nextOrPrev($id, $model->category_id);
         $nextId = $index['next'];
         $disableNext = ($nextId === null) ? 'disabled' : null;
         $prevId = $index['prev'];
         $disablePrev = ($prevId === null) ? 'disabled' : null;*/

        $dataProvider = new ActiveDataProvider([
            'query' => $good->getGoodAttributes()->joinWith([
                'attributeValues attr' => function ($query) use ($id) {
                    $query->andWhere(['=', 'attr.good_id', $id]);
                },
            ])->orderBy(['name' => SORT_ASC]),
        ]);

        $pricesProvider = new ActiveDataProvider([
            'query' => $good->getPrices(),
        ]);

        $imagesForm = new ImagesForm();

        if ($imagesForm->load(Yii::$app->request->post()) && $imagesForm->validate()) {
            try {
                $this->service->addImages($good->id, $imagesForm);
                return $this->redirect(['view', 'id' => $good->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('view', [
            'good'           => $good,
            'dataProvider'   => $dataProvider,
            'pricesProvider' => $pricesProvider,
            'imagesForm'     => $imagesForm,
            /* 'nextId'         => $nextId,
             'prevId'         => $prevId,
             'disableNext'    => $disableNext,
             'disablePrev'    => $disablePrev,*/
        ]);
    }

    /**
     * Creates a new Good model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Good();
        $form = new GoodForm();
        $values = $this->initValues($model);

        $post = Yii::$app->request->post();
        if ($form->load($post) && $form->validate() && Model::loadMultiple($values, $post)) {
            try {
                $category = $this->service->create($form);
                $this->processValues($values, $category);
                return $this->redirect(['view', 'id' => $category->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model'  => $form,
            'values' => $values,
        ]);
    }

    /**
     * Updates an existing Good model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $good = $this->findModel($id);
        $values = $this->initValues($good);

        $form = new GoodForm($good);
        $post = Yii::$app->request->post();
        if ($form->load($post) && $form->validate() && Model::loadMultiple($values, $post)) {
            try {
                $this->service->edit($good->id, $form);
                $this->processValues($values, $good);
                return $this->redirect(['view', 'id' => $good->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model'          => $form,
            'good'           => $good,
            'values'         => $values,
        ]);
    }

    /**
     * Deletes an existing Good model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @param $image_id
     * @return mixed
     */
    public function actionDeleteImage($id, $image_id)
    {
        try {
            $this->service->removeImage($id, $image_id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id, '#' => 'images']);
    }

    /**
     * @param integer $id
     * @param $image_id
     * @return mixed
     */
    public function actionMoveImageUp($id, $image_id)
    {
        $this->service->moveImageUp($id, $image_id);
        return $this->redirect(['view', 'id' => $id, '#' => 'images']);
    }

    /**
     * @param integer $id
     * @param $image_id
     * @return mixed
     */
    public function actionMoveImageDown($id, $image_id)
    {
        $this->service->moveImageDown($id, $image_id);
        return $this->redirect(['view', 'id' => $id, '#' => 'images']);
    }


    /**
     * Finds the Good model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Good the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Good::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Переключает активность товара
     *
     * @param $id
     *
     * @var $Good \app\models\Good
     */
    public function actionToggleActive($id)
    {
        $Good = $this->findModel($id);

        if ($Good->status == 0) {
            $Good->status = 1;
        } else {
            $Good->status = 0;
        }

        if ($Good->save()) {
            return $this->redirect('/admin/shop/goods');
        };
    }

    private function initValues(Good $model)
    {
        /** @var AttributeValue[] $values */
        $values = $model->getAttributeValues()->with('goodAttribute')->indexBy('attribute_id')->all();
        $attributes = Attribute::find()->indexBy('id')->all();

        $arr = array_diff_key($attributes, $values);
        foreach ($arr as $attribute) {
            $values[$attribute->id] = new AttributeValue(['attribute_id' => $attribute->id]);
        }

        uasort($values, function ($a, $b) {
            return $a->goodAttribute->name > $b->goodAttribute->name;
        });

        foreach ($values as $value) {
            $value->setScenario(AttributeValue::SCENARIO_TABULAR);
        }

        return $values;
    }

    private function processValues($values, Good $model)
    {
        foreach ($values as $value) {
            $value->good_id = $model->id;
            if ($value->validate()) {
                if (!empty($value->value)) {
                    $value->save(false);
                } else {
                    $value->delete();
                }
            }
        }
    }
}
