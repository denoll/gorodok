<?php

namespace common\models\auto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\auto\AutoBrands;

/**
 * BrandsSearch represents the model behind the search form about `common\models\auto\AutoBrands`.
 */
class BrandsSearch extends AutoBrands
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'item_type', 'version'], 'integer'],
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
        $query = AutoBrands::find();

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
            'item_type' => $this->item_type,
            'version' => $this->version,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
