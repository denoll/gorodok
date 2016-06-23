<?php

namespace common\models\banners;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\banners\BannerItem;

/**
 * ItemSearch represents the model behind the search form about `common\models\banners\BannerItem`.
 */
class ItemSearch extends BannerItem
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'id_adv_company', 'id_user', 'status', 'order', 'created_at', 'updated_at', 'size',
				'click_count', 'last_click', 'max_click',
				'hit_count', 'last_hit', 'max_hit',
				'day_count','last_day', 'max_day',
			], 'integer'],
			[['path', 'url', 'caption', 'start', 'stop', 'banner_key'], 'safe'],
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
		$query = BannerItem::find();

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
			'id_adv_company' => $this->id_adv_company,
			'id_user' => $this->id_user,
			'banner_key' => $this->banner_key,
			'status' => $this->status,
			'order' => $this->order,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'click_count' => $this->click_count,
			'hit_count' => $this->hit_count,
			'day_count' => $this->day_count,
			'max_click' => $this->max_click,
			'max_hit' => $this->max_hit,
			'max_day' => $this->max_day,
			'last_click' => $this->last_click,
			'last_hit' => $this->last_hit,
			'last_day' => $this->last_day,
			'start' => $this->start,
			'stop' => $this->stop,
			'size' => $this->size,
		]);

		$query->andFilterWhere(['like', 'path', $this->path])
			->andFilterWhere(['like', 'url', $this->url])
			->andFilterWhere(['like', 'caption', $this->caption]);

		return $dataProvider;
	}
}
