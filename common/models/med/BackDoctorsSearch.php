<?php

namespace common\models\med;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\med\Doctors;

/**
 * BackDoctorsSearch represents the model behind the search form about `common\models\med\Doctors`.
 */
class BackDoctorsSearch extends Doctors
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_spec', 'status', 'confirmed', 'exp', 'receiving'], 'integer'],
            [['rank', 'about', 'address', 'documents', 'updated_at', 'created_at', 'm_keyword', 'm_description'], 'safe'],
            [['price'], 'number'],
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
        $query = Doctors::find();

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
            'id_user' => $this->id_user,
            'id_spec' => $this->id_spec,
            'status' => $this->status,
            'confirmed' => $this->confirmed,
            'price' => $this->price,
            'exp' => $this->exp,
            'receiving' => $this->receiving,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'rank', $this->rank])
            ->andFilterWhere(['like', 'about', $this->about])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'documents', $this->documents])
            ->andFilterWhere(['like', 'm_keyword', $this->m_keyword])
            ->andFilterWhere(['like', 'm_description', $this->m_description]);

        return $dataProvider;
    }
}
