<?php

namespace app\modules\admin\controllers\documents;

use app\core\entities\Document\Order;
use app\core\entities\Document\OrderItem;
use app\core\forms\manage\Document\OrderItemForm;
use app\core\repositories\Document\OrderItemRepository;
use app\core\repositories\Document\OrderRepository;
use app\core\services\manage\Document\OrderManageService;
use app\modules\trade\models\OrderSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OrdersController implements the CRUD actions for Order model.
 */
class OrdersController extends Controller
{
    private $service;
    private $documents;
    private $documentItems;

    public function __construct($id, $module, OrderManageService $service, OrderRepository $documents, OrderItemRepository $documentItems, $config = [])
    {
        $this->service = $service;
        $this->documents = $documents;
        $this->documentItems = $documentItems;
        parent::__construct($id, $module, $config);
    }

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
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $document =  $this->documents->get($id);

        $documentTableForm = new OrderItemForm();

        if ($documentTableForm->load(Yii::$app->request->post()) && $documentTableForm->validate()) {
            try {
                $this->service->addItem($document->id, $documentTableForm);
                return $this->redirect(['view', 'id' => $document->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        if ($document->load(Yii::$app->request->post()) && $document->save()) {
            return $this->redirect(['view', 'id' => $document->id]);
        }

        $itemsDataProvider = new ActiveDataProvider([
            'query' => OrderItem::find()->where(['document_id' => $id]),
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                ]
            ]
        ]);

        return $this->render('view', [
            'document' => $document,
            'itemsDataProvider' => $itemsDataProvider,
            'documentTableForm' => $documentTableForm
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing Order model.
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

        $form = new OrderItemForm($documentItem);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editItem($documentItem, $form);
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return \app\core\entities\Document\Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
