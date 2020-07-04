<?php


namespace app\modules\cart\controllers;


use app\core\readModels\Shop\GoodReadRepository;
use app\modules\cart\forms\CartForm;
use app\modules\cart\models\Cart;
use yii\filters\VerbFilter;
use yii\web\Controller;

class DefaultController extends Controller
{
    /**
     * @var Cart
     */
    private $cart;
    /**
     * @var GoodReadRepository
     */
    private $goodReadRepository;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add' => ['post'],
                    'edit' => ['post'],
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function __construct($id, $module, Cart $cart, GoodReadRepository $goodReadRepository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->cart = $cart;
        $this->goodReadRepository = $goodReadRepository;
    }

    public function actionIndex()
    {
        $cart = $this->cart;
        return $this->render('index', compact('cart'));
    }

    public function actionAdd()
    {

        $cartForm = new CartForm();
        if ($cartForm->load(\Yii::$app->request->post()) && $cartForm->validate()) {
            $good = $this->goodReadRepository->find($cartForm->goodId);
            $this->cart->add($good, $cartForm->qty);
        }
        return $this->redirect('index');
    }

    public function actionEdit()
    {
        $cartForm = new CartForm();

        if (\Yii::$app->request->isAjax) {
            if ($cartForm->load(\Yii::$app->request->post(), 'CartForm') && $cartForm->validate()) {
                $good = $this->goodReadRepository->find($cartForm->goodId);
                $this->cart->set($good, $cartForm->qty);
            }
        }
    }

    public function actionDelete($id)
    {
        if (\Yii::$app->request->isAjax) {
            $good = $this->goodReadRepository->find($id);
            $this->cart->delete($good->id);
        }
    }
}