<?php

namespace app\modules\user\controllers;

use app\modules\user\models\PasswordChangeForm;
use app\modules\user\models\ProfileUpdateForm;
use app\modules\user\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = User::find()->andWhere(['id' => Yii::$app->user->identity->getId()])->with(['partner.orders'])->one();

        $orderDataProvider = new ActiveDataProvider([
            'query' => $user->partner->getOrders(),
        ]);
        $orders = $orderDataProvider->getModels();
        return $this->render('index', [
            'model' => $user,
            'orders' => $orders,
            'pagination' => $orderDataProvider->pagination,
        ]);
    }

    public function actionUpdate()
    {
        $user = $this->findModel();
        $form = new ProfileUpdateForm($user);

        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $form->photo = UploadedFile::getInstance($form, 'photo');
                    $form->update();
                    return $this->redirect(['index']);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }

        }
            return $this->render('update', [
                'model' => $form,
                'user' => $user,
            ]);

    }

    public function actionPasswordChange()
    {
        $user = $this->findModel();
        $model = new PasswordChangeForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('passwordChange', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return User the loaded model
     */
    private function findModel()
    {
        return User::findOne(Yii::$app->user->identity->getId());
    }
}