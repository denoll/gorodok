<?php

namespace common\models\banners;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\banners\BannerAdv;

/**
 * AdvertSearch represents the model behind the search form about `common\models\banners\BannerAdv`.
 */
class AdvertSearch extends BannerAdv
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'status', 'hit_status', 'click_status', 'day_status', 'hit_size', 'click_size', 'day_size', 'width', 'height'], 'integer'],
			[['click_price', 'day_price', 'hit_price'], 'number'],
			[['name'], 'string', 'max' => 100],
			[['description'], 'string', 'max' => 500],
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
		$query = BannerAdv::find();

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
			'status' => $this->status,
			'hit_price' => $this->hit_price,
			'click_price' => $this->click_price,
			'day_price' => $this->day_price,
			'hit_status' => $this->hit_status,
			'click_status' => $this->click_status,
			'day_status' => $this->day_status,
			'hit_size' => $this->hit_size,
			'click_size' => $this->click_size,
			'day_size' => $this->day_size,
		]);

		$query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'height', $this->height])
			->andFilterWhere(['like', 'width', $this->width])
			->andFilterWhere(['like', 'description', $this->description]);

		return $dataProvider;
	}
}
