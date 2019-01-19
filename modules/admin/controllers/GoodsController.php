<?php

namespace app\modules\admin\controllers;

use app\models\Attribute;
use app\models\AttributeValue;
use app\models\Image;
use Yii;
use app\models\Good;
use app\modules\admin\models\GoodSearch;
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
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        $model = $this->findModel($id);

        $index = Good::nextOrPrev($id, $model->categoryId);
        $nextId = $index['next'];
        $disableNext = ($nextId === null) ? 'disabled' : null;
        $prevId = $index['prev'];
        $disablePrev = ($prevId === null) ? 'disabled' : null;

        $dataProvider = new ActiveDataProvider([
            'query' => $model->getGoodAttributes()->joinWith([
                'attributeValues attr' => function ($query) use ($id) {
                    $query->andWhere(['=', 'attr.good_id', $id]);
                }
            ])->orderBy(['name' => SORT_ASC])
        ]);

        return $this->render('view', [
            'model'        => $model,
            'dataProvider' => $dataProvider,
            'nextId'       => $nextId,
            'prevId'       => $prevId,
            'disableNext'  => $disableNext,
            'disablePrev'  => $disablePrev,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
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
        $model = $this->findModel($id);

        $imagesProvider = new ActiveDataProvider([
            'query' => $model->getImages(),
        ]);

        /** @var AttributeValue[] $values */
        $values = $model->getAttributeValues()->with('goodAttribute')->indexBy('attribute_id')->all();
        $attributes = Attribute::find()->indexBy('id')->all();

        $arr = array_diff_key($attributes, $values);
        foreach ($arr as $attribute) {
            $values[$attribute->id] = new AttributeValue(['attribute_id' => $attribute->id]);
        }

        usort($values, function ($a, $b) {
            return $a->goodAttribute->name > $b->goodAttribute->name;
        });

        foreach ($values as $value) {
            $value->setScenario(AttributeValue::SCENARIO_TABULAR);
        }
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->save() && Model::loadMultiple($values, $post)) {
            foreach ($values as $value) {
                $value->good_id = $model->id;
                if ($value->validate()) {
                    if (!empty($value->value)) {
                        $value->save(false);
                    }
                    else {
                        $value->delete();
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model'          => $model,
            'imagesProvider' => $imagesProvider,
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

        if ($Good->active == 0) {
            $Good->active = 1;
        }
        else {
            $Good->active = 0;
        }

        if ($Good->save()) {
            return $this->redirect('/admin/goods');
        };
    }
}
