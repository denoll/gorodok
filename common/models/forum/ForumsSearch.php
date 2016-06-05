<?php

namespace common\models\forum;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\forum\Forums;

/**
 * ForumsSearch represents the model behind the search form about `common\models\Forums`.
 */
class ForumsSearch extends Forums
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status','on_main','order'], 'integer'],
            [['name', 'alias', 'created_at', 'modify_at', 'description', 'm_keywords', 'm_description'], 'safe'],
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
        $query = Forums::find();

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
	        'on_main'=> $this->on_main,
	        'order'=> $this->order,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'modify_at' => $this->modify_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'm_keywords', $this->m_keywords])
            ->andFilterWhere(['like', 'm_description', $this->m_description]);

        return $dataProvider;
    }
}
