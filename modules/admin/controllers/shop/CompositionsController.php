<?php

namespace app\modules\admin\controllers\shop;

use app\core\entities\Shop\Composition;
use app\core\forms\manage\Shop\CompositionForm;
use app\core\repositories\Shop\CompositionRepository;
use app\core\repositories\Shop\GoodRepository;
use app\core\services\manage\Shop\CompositionManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CompositionsController implements the CRUD actions for Composition model.
 */
class CompositionsController extends Controller
{
    private $service;
    private $goods;
    private $compositions;

    public function __construct(
        $id,
        $module,
        CompositionManageService $service,
        GoodRepository $goods,
        CompositionRepository $compositions,
        $config = []
    ) {
        $this->service = $service;
        $this->goods = $goods;
        $this->compositions = $compositions;
        parent::__construct($id, $module, $config);
    }

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
     * Creates a new Composition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $goodId int
     * @return mixed
     */
    public function actionCreate($goodId)
    {
        $form = new CompositionForm();
        $good = $this->goods->get($goodId);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $composition = $this->service->create($form);
                return $this->redirect(['/admin/shop/goods/view', 'id' => $composition->good_id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
            'good'  => $good,
        ]);
    }

    /**
     * Updates an existing Composition model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $goodId
     * @param integer $materialId
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($goodId, $materialId)
    {
        $composition = $this->compositions->get($goodId, $materialId);
        $form = new CompositionForm($composition);
        $good = $this->goods->get($goodId);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($goodId, $materialId, $form);
                return $this->redirect(['/admin/shop/goods/view', 'id' => $composition->good_id]);
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
     * Deletes an existing Composition model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $goodId
     * @param integer $materialId
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($goodId, $materialId)
    {
        $good = $this->goods->get($goodId);

        try {
            $this->service->remove($goodId, $materialId);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['/admin/shop/goods/view', 'id' => $good->id]);
    }

    /**
     * Finds the Composition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Composition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($goodId, $materialId)
    {
        if (($model = Composition::findOne(['good_id' => $goodId, 'material_id' => $materialId])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
