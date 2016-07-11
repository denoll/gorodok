<?php

namespace common\models\konkurs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\konkurs\Konkurs;

/**
 * KonkursSearch represents the model behind the search form about `common\models\konkurs\Konkurs`.
 */
class KonkursSearchFront extends Konkurs
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'status', 'show_img', 'show_des', 'stars', 'width', 'height', 'id_cat'], 'integer'],
			[['name', 'slug', 'title', 'description', 'base_url', 'img', 'start', 'stop', 'created_at', 'updated_at', 'mk', 'md'], 'safe'],
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
		$query = Konkurs::find()->with('cat')->where(['status'=>Konkurs::STATUS_ACTIVE]);

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
				'start' => [
					'asc' => ['start' => SORT_ASC,],
					'desc' => ['start' => SORT_DESC,],
					'label' => 'по дате',
				],
				'name' => [
					'asc' => ['name' => SORT_ASC,],
					'desc' => ['name' => SORT_DESC,],
					'label' => 'по названию',
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
			'id_cat' => $this->id_cat,
			'status' => $this->status,
			'show_img' => $this->show_img,
			'show_des' => $this->show_des,
			'stars' => $this->stars,
			'width' => $this->width,
			'height' => $this->height,
			'start' => $this->start,
			'stop' => $this->stop,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		]);

		$query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'slug', $this->slug])
			->andFilterWhere(['like', 'title', $this->title])
			->andFilterWhere(['like', 'description', $this->description])
			->andFilterWhere(['like', 'img', $this->img])
			->andFilterWhere(['like', 'mk', $this->mk])
			->andFilterWhere(['like', 'md', $this->md]);

		return $dataProvider;
	}
}
