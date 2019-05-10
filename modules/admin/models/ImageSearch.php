<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\core\entities\Shop\Good\Image;

/**
 * ImageSearch represents the model behind the search form of `app\core\entities\Shop\Good\Image`.
 */
class ImageSearch extends \app\core\entities\Shop\Good\Image
{
    public function behaviors()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'good_id', 'main'], 'integer'],
            [['file_name'], 'safe'],
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
        $query = Image::find();

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
            'good_id' => $this->good_id,
            'main' => $this->main,
        ]);

        $query->andFilterWhere(['like', 'file_name', $this->file_name]);

        return $dataProvider;
    }
}
