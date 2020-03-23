<?php

namespace app\modules\catalog\widgets;

use app\core\entities\Shop\Category;
use app\core\readModels\Shop\CategoryReadRepository;
use app\core\readModels\Shop\GoodReadRepository;
use yii\base\Widget;

class CategoriesWidget extends Widget
{
    public $context;

    private $categories;
    private $goods;

    public function __construct(CategoryReadRepository $categories, GoodReadRepository $goods, $config = [])
    {
        parent::__construct($config);
        $this->categories = $categories;
        $this->goods = $goods;
    }

    public function run()
    {
        /** @var Category|null */
        $activeCategory = null;

        $categories = Category::getCategoriesInRoot();

        /*if ($this->context->action->id == 'good') {
            $good = $this->goods->find($this->context->actionParams['id']);
            $activeCategory = $good->category;
        } elseif ($this->context->action->id == 'category') {
            $activeCategory = $this->categories->find($this->context->actionParams['id']);
        }*/

        return $this->render('categories', [
            'categories' => $categories
            //'activeCategory' => $activeCategory,
        ]);
    }
}