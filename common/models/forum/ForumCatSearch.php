<?php

namespace common\models\forum;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\forum\ForumCat;

/**
 * ForumCatSearch represents the model behind the search form about `common\models\ForumCat`.
 */
class ForumCatSearch extends ForumCat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_forum', 'order', 'status'], 'integer'],
            [['name', 'alias', 'created_at', 'modify_at', 'description', 'm_keyword', 'm_description'], 'safe'],
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
        $query = ForumCat::find();

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
            'id_forum' => $this->id_forum,
            'order' => $this->order,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'modify_at' => $this->modify_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'm_keyword', $this->m_keyword])
            ->andFilterWhere(['like', 'm_description', $this->m_description]);

        return $dataProvider;
    }
}
