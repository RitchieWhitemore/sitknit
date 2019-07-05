<?php

namespace app\modules\trade\models;

use app\core\entities\Shop\Price;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PriceSearch represents the model behind the search form of `app\core\entities\Shop\Price`.
 */
class PriceSearch extends Price
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type_price', 'good_id'], 'integer'],
            [['date'], 'safe'],
            [['price'], 'number'],
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
        $query = Price::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'         => $this->id,
            'date'       => $this->date,
            'type_price' => $this->type_price,
            'price'      => $this->price,
            'good_id'    => $this->good_id,
        ]);

        return $dataProvider;
    }
}
