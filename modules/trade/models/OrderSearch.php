<?php

namespace app\modules\trade\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderSearch represents the model behind the search form of `app\core\entities\Document\Order`.
 */
class OrderSearch extends \app\core\entities\Document\Order
{
    public $partner;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'payment', 'partner_id'], 'integer'],
            [['date', 'partner'], 'safe'],
            [['total'], 'number'],
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
        $query = \app\core\entities\Document\Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC
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
            'id' => $this->id,
            'date' => $this->date,
            'status' => $this->status,
            'payment' => $this->payment,
            'partner_id' => $this->partner_id,
            'total' => $this->total,
        ]);

        $query->andFilterWhere(['like', 'partner.name', $this->partner]);

        return $dataProvider;
    }
}
