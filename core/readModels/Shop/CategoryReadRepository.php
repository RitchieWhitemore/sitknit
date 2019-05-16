<?php


namespace app\core\readModels\Shop;


use app\core\entities\Shop\Category;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class CategoryReadRepository
{
    public function getRoot(): Category
    {
        return Category::find()->roots()->one();
    }

    public function find($id)
    {
        return Category::find()->andWhere(['id' => $id])->andWhere(['>', 'depth', 0])->one();
    }

    public function findBySlug($slug)
    {
        return Category::find()->andWhere(['slug' => $slug])->andWhere(['>', 'depth', 0])->one();
    }

    public function getTreeWithSubsOf(Category $category = null): array
    {
        $query = Category::find()->andWhere(['>', 'depth', 0])->orderBy('lft');
        if ($category) {
            $criteria = ['or', ['depth' => 1]];
            foreach (ArrayHelper::merge([$category], $category->parents) as $item) {
                $criteria[] = ['and', ['>', 'lft', $item->lft], ['<', 'rgt', $item->rgt], ['depth' => $item->depth + 1]];
            }
            $query->andWhere($criteria);
        } else {
            $query->andWhere(['depth' => 1]);
        }
        return $query->all();
    }

    public function getCategoriesInRoot(): ActiveDataProvider
    {
        $query = Category::find()->andWhere(['>', 'depth', 0])->active()->orderBy('lft');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}