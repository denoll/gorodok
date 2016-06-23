<?php

namespace common\models\banners;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * WidgetBannerSearch represents the model behind the search form about `common\models\WidgetBanner`.
 */
class BannerSearch extends Banner
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['status', 'stage', 'col_size'], 'integer'],
			[['key', 'name'], 'string'],
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
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = Banner::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'key' => $this->key,
			'name' => $this->name,
			'status' => $this->status,
			'stage' => $this->stage,
			'col_size' => $this->col_size,
		]);

		$query->andFilterWhere(['like', 'key', $this->key]);

		return $dataProvider;
	}
}
