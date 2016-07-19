<?php

namespace common\models\auto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\auto\AutoModify;

/**
 * ModifySearch represents the model behind the search form about `common\models\auto\AutoModify`.
 */
class ModifySearch extends AutoModify
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'version_id', 'y_from', 'y_to', 'item_type', 'version'], 'integer'],
            [['name'], 'safe'],
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
        $query = AutoModify::find();

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
            'model_id' => $this->model_id,
            'version_id' => $this->version_id,
            'y_from' => $this->y_from,
            'y_to' => $this->y_to,
            'item_type' => $this->item_type,
            'version' => $this->version,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
