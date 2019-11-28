<?php


namespace app\core\readModels\Shop;


use app\core\entities\Shop\Brand;
use app\core\entities\Shop\Category;
use app\core\entities\Shop\Good\Good;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class GoodReadRepository
{
    public function getAll(): DataProviderInterface
    {
        $query = Good::find()->alias('g')->active('g')->with('mainPhoto');
        return $this->getProvider($query);
    }

    public function getAllByCategory(Category $category): DataProviderInterface
    {
        $query = Good::find()->alias('g')->active('g')->with('mainImage', 'category');

        $ids = ArrayHelper::merge([$category->id], $category->getDescendants()->select('id')->column());

        $query->joinWith(['categoryAssignments ca'], false);
        $query->andWhere(['or', ['g.category_id' => $ids], ['ca.category_id' => $ids]]);
        $query->groupBy('g.id');

        return $this->getProvider($query);
    }

    public function getAllByBrand(Brand $brand): DataProviderInterface
    {
        $query = Good::find()->alias('g')->active('g')->with('mainPhoto');
        $query->andWhere(['g.brand_id' => $brand->id]);

        return $this->getProvider($query);
    }

    public function getSiblingGoods(Good $good)
    {
        return Good::find()->where(['like', 'name', $good->name])
            ->andWhere(['!=', 'id', $good->id])
            ->with(['valueColorRelation'])
            ->all();
    }

    public function getOtherColors(Good $good)
    {
        return Good::find()->where(['name' => $good->name])
            ->andWhere(['!=', 'id', $good->id])->all();
    }

    public function find($id)
    {
        return Good::find()->active()->andWhere(['id' => $id])->one();
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort'  => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes'   => [
                    'id'     => [
                        'asc'  => ['g.id' => SORT_ASC],
                        'desc' => ['g.id' => SORT_DESC],
                    ],
                    'name'   => [
                        'asc'  => ['g.nameAndColor' => SORT_ASC],
                        'desc' => ['g.nameAndColor' => SORT_DESC],
                    ],
                ],
            ],
            'pagination' => [
                'pageSizeLimit' => [15, 100],
            ]
        ]);
    }
}