<?php

namespace app\modules\admin\controllers\shop;

use app\components\SetPrice;
use app\core\entities\Shop\Price;
use app\core\forms\manage\Shop\PriceForm;
use app\core\readModels\Shop\RemainingReadRepository;
use app\core\repositories\Shop\PriceRepository;
use app\core\services\manage\Shop\PriceManageService;
use app\modules\trade\models\SetPriceAjaxForm;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * PricesController implements the CRUD actions for Price model.
 */
class PricesController extends Controller
{
    private $remaining;
    private $service;
    private $repository;

    public function __construct(
        $id,
        $module,
        RemainingReadRepository $remaining,
        PriceManageService $service,
        PriceRepository $repository,
        $config = []
    ) {
        $this->remaining = $remaining;
        $this->service = $service;
        $this->repository = $repository;
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
     * Lists all Price models.
     *
     * @return mixed
     */
    public function actionIndex($notNull = null)
    {
        $remaining = $this->remaining->getLastRemaining($notNull);

        $remainingActiveProvider = new ArrayDataProvider([
            'allModels'  => $remaining,
            'pagination' => false,
        ]);

        return $this->render('index',
            ['remainingActiveProvider' => $remainingActiveProvider]);
    }

    /**
     * Displays a single Price model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Price model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new PriceForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $price = $this->service->create($form);
                return $this->redirect(['view', 'id' => $price->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionCreateAjax()
    {
        $form = new PriceForm();

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                if ($this->repository->existsPrice($form)) {
                    return "Такая цена существует";
                }

                $oldPrice = $this->repository->findPriceOnDate($form);

                if ($oldPrice != null) {
                    $price = $this->service->editOldPriceOnDate($oldPrice,
                        $form);
                } else {
                    $price = $this->service->create($form);
                }

                return 'Цена ' . $price->price . ' для '
                    . $price->good->nameAndColor . ' установлена';

            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return 'неудача';

    }

    /**
     * Updates an existing Price model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Price model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSetPrices()
    {
        $model = new SetPriceAjaxForm();

        if (Yii::$app->request->isPost) {
            $model->attributes = Yii::$app->request->post('SetPriceForm');
            // $model->file_price = UploadedFile::getInstance($model, 'file_input_price');

            $setPrice = new SetPrice($model);
            $setPrice->run();

            $session = Yii::$app->session;
            $session->setFlash('priceImported', 'Прайс успешно загружен');
            $this->redirect('set-prices');
        }


        return $this->render('set-prices', ['model' => $model]);
    }

    /**
     * Finds the Price model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return \app\core\entities\Shop\Price the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Price::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
