<?php

namespace app\modules\admin\forms;

use app\core\entities\Shop\Good\Good;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * GoodSearch represents the model behind the search form of `app\models\Good`.
 */
class GoodSearch extends Model
{
    public $id;
    public $article;
    public $name;
    public $category_id;
    public $brand_id;
    public $packaged;
    public $status;
    public $description;
    public $characteristic;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'brand_id', 'packaged', 'status'], 'integer'],
            [['article', 'name', 'description', 'characteristic'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
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
        $query = Good::find()->joinWith(['category']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['category_id' => SORT_ASC, 'name' => SORT_ASC, 'article' => SORT_ASC],
                'attributes' => [
                    'article',
                    'name',
                    'category_id' => [
                        'asc' => ['category.name' => SORT_ASC],
                        'desc' => ['category.name' => SORT_DESC],
                    ]
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'good.id' => $this->id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'packaged' => $this->packaged,
            'good.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'article', $this->article])
            ->andFilterWhere(['like', 'good.name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'characteristic', $this->characteristic]);

        return $dataProvider;
    }
}
