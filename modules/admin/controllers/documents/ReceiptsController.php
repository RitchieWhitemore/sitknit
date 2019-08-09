<?php

namespace app\modules\admin\controllers\documents;

use app\core\entities\Document\Receipt;
use app\core\entities\Document\ReceiptItem;
use app\core\forms\manage\Document\ReceiptItemForm;
use app\core\repositories\Document\ReceiptItemRepository;
use app\core\repositories\Document\ReceiptRepository;
use app\core\services\manage\Document\ReceiptManageService;
use app\core\services\manage\Shop\PriceManageService;
use app\modules\trade\models\ReceiptSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ReceiptsController implements the CRUD actions for Receipt model.
 */
class ReceiptsController extends Controller
{
    private $service;
    private $documents;
    private $documentItems;
    private $priceManageService;

    public function __construct(
        $id,
        $module,
        ReceiptManageService $service,
        ReceiptRepository $documents,
        ReceiptItemRepository $documentItems,
        PriceManageService $priceManageService,
        $config = []
    ) {
        $this->service = $service;
        $this->documents = $documents;
        $this->documentItems = $documentItems;
        $this->priceManageService = $priceManageService;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'item-delete' => ['POST'],
                    'move-item-up'   => ['POST'],
                    'move-item-down' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Receipt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReceiptSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Receipt model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $receipt =  $this->documents->get($id);

        $documentTableForm = new ReceiptItemForm();

        if ($documentTableForm->load(Yii::$app->request->post()) && $documentTableForm->validate()) {
            try {
                $this->service->addItem($receipt->id, $documentTableForm);
                return $this->redirect(['view', 'id' => $receipt->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        $itemsDataProvider = new ActiveDataProvider([
            'query' => ReceiptItem::find()->where(['document_id' => $id]),
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                ]
            ]
        ]);

        return $this->render('view', [
            'receipt' => $receipt,
            'itemsDataProvider' => $itemsDataProvider,
            'documentTableForm' => $documentTableForm
        ]);
    }

    /**
     * Creates a new Receipt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Receipt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Receipt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->priceManageService->setPricesByDocument($model);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Receipt model.
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

    public function actionItemDelete($documentId, $goodId)
    {
        try {
            $this->service->remove($documentId, $goodId);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $documentId]);

    }

    public function actionItemUpdate($documentId, $goodId)
    {
        $documentItem  = $this->documentItems->get($documentId, $goodId);

        $form = new ReceiptItemForm($documentItem);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editItem($documentItem, $form);
                $this->priceManageService->setPriceByItemDocument($documentItem);
                return $this->redirect(['view', 'id' => $documentItem->document_id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('item-update', [
            'item' => $documentItem,
            'documentTableForm' => $form,
        ]);
    }

    public function actionMoveItemUp($documentId, $goodId)
    {
        $this->service->moveItemUp($documentId, $goodId);
        return $this->redirect(['view', 'id' => $documentId]);
    }

    public function actionMoveItemDown($documentId, $goodId)
    {
        $this->service->moveItemDown($documentId, $goodId);
        return $this->redirect(['view', 'id' => $documentId]);
    }

    /**
     * Finds the Receipt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Receipt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Receipt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
