<?php

namespace app\modules\metatags\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Metatags;

/**
 * Search represents the model behind the search form about `common\models\Metatags`.
 */
class Search extends Metatags
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'url', 'kw', 'desc', 'info'], 'safe'],
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
        $query = Metatags::find();

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
        $query->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'kw', $this->kw])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'info', $this->info]);

        return $dataProvider;
    }
}
