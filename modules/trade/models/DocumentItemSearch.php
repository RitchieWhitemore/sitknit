<?php

namespace app\modules\trade\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\trade\models\DocumentItem;

/**
 * DocumentItemSearch represents the model behind the search form of `app\modules\trade\models\DocumentItem`.
 */
class DocumentItemSearch extends DocumentItem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'document_id', 'good_id', 'qty'], 'integer'],
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
        $query = DocumentItem::find();

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
            'id' => $this->id,
            'document_id' => $this->document_id,
            'good_id' => $this->good_id,
            'qty' => $this->qty,
            'price' => $this->price,
        ]);

        return $dataProvider;
    }
}
