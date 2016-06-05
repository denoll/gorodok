<?php

namespace common\models\forum;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\forum\ForumMessage;

/**
 * ForumMessageSearch represents the model behind the search form about `common\models\ForumMessage`.
 */
class ForumMessageSearch extends ForumMessage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_theme', 'id_cat', 'id_author', 'status'], 'integer'],
            [['created_at', 'modify_at', 'message'], 'safe'],
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
    public function search($params, $id)
    {
        $query = ForumMessage::find();

	    $query->where(['id_theme'=>$id]);

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
            'id_theme' => $this->id_theme,
            'id_cat' => $this->id_cat,
            'id_author' => $this->id_author,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'modify_at' => $this->modify_at,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
