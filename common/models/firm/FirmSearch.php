<?php

namespace common\models\firm;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\firm\Firm;

/**
 * FirmSearch represents the model behind the search form about `common\models\firm\Firm`.
 */
class FirmSearch extends Firm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_cat', 'id_user', 'status', 'show_requisites'], 'integer'],
            [['name', 'tel', 'email', 'site', 'logo', 'description', 'created_at', 'updated_at', 'mk', 'md', 'address', 'lat', 'lon'], 'safe'],
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
        $query = Firm::find();

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
            'id_cat' => $this->id_cat,
            'id_user' => $this->id_user,
            'status' => $this->status,
            'show_requisites' => $this->show_requisites,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'lon', $this->lon])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'mk', $this->mk])
            ->andFilterWhere(['like', 'md', $this->md]);

        return $dataProvider;
    }
}
