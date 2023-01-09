<?php

namespace common\modules\publication\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\publication\models\Publication;

/**
 * PublicationSearch represents the model behind the search form of `common\modules\publication\models\Publication`.
 */
class PublicationSearch extends Publication
{
    /**
     * {@inheritdoc}
     */
    public $test;
    public function rules()
    {
        return [
            [['id', 'category_id', 'sub_category_id', 'tariff_id', 'is_mutually_surcharged', 'is_active'], 'integer'],
            [['link_video', 'title', 'description', 'location','test'], 'safe'],
            [['price', 'latitude', 'longitude'], 'number'],
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
        $query = Publication::find();

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
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'price' => $this->price,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'tariff_id' => $this->tariff_id,
            'is_mutually_surcharged' => $this->is_mutually_surcharged,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'link_video', $this->link_video])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'location', $this->location]);

        return $dataProvider;
    }
}
