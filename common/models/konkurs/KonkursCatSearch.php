<?php

namespace common\models\konkurs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\konkurs\KonkursCat;

/**
 * KonkursCatSearch represents the model behind the search form about `common\models\konkurs\KonkursCat`.
 */
class KonkursCatSearch extends KonkursCat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_parent', 'status', 'order'], 'integer'],
            [['name', 'slug', 'mk', 'md'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = KonkursCat::find();

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
            'id_parent' => $this->id_parent,
            'status' => $this->status,
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'mk', $this->mk])
            ->andFilterWhere(['like', 'md', $this->md]);

        return $dataProvider;
    }
}
