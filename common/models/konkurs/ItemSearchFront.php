<?php

namespace common\models\konkurs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\konkurs\KonkursItem;

/**
 * ItemSearch represents the model behind the search form about `common\models\konkurs\KonkursItem`.
 */
class ItemSearchFront extends KonkursItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_konkurs', 'id_user', 'status', 'yes', 'no', 'scope'], 'integer'],
            [['base_url', 'img', 'description', 'created_at', 'updated_at'], 'safe'],
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
     * @param array $params
     * @param integer $id_konkurs
     *
     * @return ActiveDataProvider
     */
    public function search($params, $id_konkurs)
    {
        $query = KonkursItem::find()->with('user')->where(['id_konkurs'=>$id_konkurs]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 20,
            ],
        ]);
        $dataProvider->setSort([
            'attributes' => [
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC,],
                    'desc' => ['created_at' => SORT_DESC,],
                    'label' => 'по дате',
                ],
                'id_user' => [
                    'asc' => ['id_user' => SORT_ASC,],
                    'desc' => ['id_user' => SORT_DESC,],
                    'label' => 'по пользователю',
                ],
            ],
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
            'id_konkurs' => $this->id_konkurs,
            'id_user' => $this->id_user,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'yes' => $this->yes,
            'no' => $this->no,
            'scope' => $this->scope,
        ]);

        $query->andFilterWhere(['like', 'base_url', $this->base_url])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
