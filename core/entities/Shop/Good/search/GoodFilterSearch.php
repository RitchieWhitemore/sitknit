<?php


namespace app\core\entities\Shop\Good\search;


use app\core\entities\Shop\Good\Good;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class GoodFilterSearch extends Good
{
    public $pageSize = 9;

    public $brandIds;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brandIds'], 'safe'],
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
        $query = Good::find()->from('good')->active('good')->activeBrand()->joinWith(['categoryAssignments c']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query
            ->andWhere(['OR', ['good.category_id' => $this->category_id], ['c.category_id' => $this->category_id]])
            ->andFilterWhere(['IN', 'brand_id', $this->brandIds]);

        return $dataProvider;
    }
}