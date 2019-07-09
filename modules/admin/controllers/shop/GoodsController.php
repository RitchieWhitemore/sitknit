<?php

namespace app\modules\admin\controllers\shop;

use app\core\entities\Shop\Good\Good;
use app\core\forms\manage\Shop\Good\GoodForm;
use app\core\forms\manage\Shop\Good\ImagesForm;
use app\core\services\manage\Shop\GoodManageService;
use app\modules\admin\forms\GoodSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
                    'delete'          => ['POST'],
                    'delete-photo'    => ['POST'],
                    'move-photo-up'   => ['POST'],
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

        $pricesProvider = new ActiveDataProvider([
            'query' => $good->getPrices(),
        ]);

        $compositionProvider = new ActiveDataProvider([
            'query' => $good->getCompositions(),
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
            'good'                => $good,
            'pricesProvider'      => $pricesProvider,
            'imagesForm'          => $imagesForm,
            'compositionProvider' => $compositionProvider,
        ]);
    }

    /**
     * Creates a new Good model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new GoodForm();

        $post = Yii::$app->request->post();
        if ($form->load($post) && $form->validate()) {
            try {
                $good = $this->service->create($form);
                return $this->redirect(['view', 'id' => $good->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
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

        $form = new GoodForm($good);
        $post = Yii::$app->request->post();
        if ($form->load($post) && $form->validate()) {
            try {
                $this->service->edit($good->id, $form);
                return $this->redirect(['view', 'id' => $good->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'good'  => $good,
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
     * @var $Good Good
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
}
