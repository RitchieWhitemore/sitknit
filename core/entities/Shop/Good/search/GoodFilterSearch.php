<?php


namespace app\core\entities\Shop\Good\search;


use app\core\entities\Shop\Good\Good;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class GoodFilterSearch extends Good
{
    public $pageSize = 15;

    public $brandIds;
    public $compositionIds;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brandIds', 'compositionIds'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Good::find()
            ->from('good')
            ->active('good')
            ->activeBrand()
            ->groupBy('name')
            ->joinWith([
                'categoryAssignments c',
                'category',
                'brand',
                'mainImage',
                'prices',
                'valuesYarnRelation.characteristic.unit'
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC,
                    'id' => SORT_ASC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query
            // ->andWhere(['c.category_id' => $this->category_id])
            ->andFilterWhere(['IN', 'brand_id', $this->brandIds])
            ->andFilterWhere(['IN', 'c.category_id', $this->compositionIds]);

        // $query->andWhere('main_good_id = good.id OR main_good_id = null');

        return $dataProvider;
    }
}