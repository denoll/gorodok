<?php

namespace common\models\konkurs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\konkurs\KonkursItem;

/**
 * ItemSearch represents the model behind the search form about `common\models\konkurs\KonkursItem`.
 */
class ItemSearch extends KonkursItem
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'id_konkurs', 'id_user', 'status', 'yes', 'no', 'vote_count'], 'integer'],
			[['scope', 'sum'],'number'],
			[['base_url', 'img', 'description', 'created_at', 'updated_at', 'name'], 'safe'],
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
		$query = KonkursItem::find()->with(['user', 'konkurs', 'vote']);

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC
				]
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
			'sum' => $this->sum,
			'vote_count' => $this->vote_count,
		]);

		$query
			->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'base_url', $this->base_url])
			->andFilterWhere(['like', 'img', $this->img])
			->andFilterWhere(['like', 'description', $this->description]);

		return $dataProvider;
	}
}
