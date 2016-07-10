<?php

namespace common\models\slider;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\slider\SliderMain;

/**
 * SliderSearch represents the model behind the search form about `common\models\slider\SliderMain`.
 */
class SliderSearch extends SliderMain
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'id_user', 'status'], 'integer'],
			[['name', 'img', 'thumbnail', 'description'], 'safe'],
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
		$query = SliderMain::find()->with('user');
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => ['defaultOrder'=> ['id'=>SORT_DESC]]
		]);

		$this->load($params);

		if (!$this->validate()) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'id' => $this->id,
			'id_user' => $this->id_user,
			'status' => $this->status,
		]);

		$query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'img', $this->img])
			->andFilterWhere(['like', 'thumbnail', $this->thumbnail])
			->andFilterWhere(['like', 'description', $this->description]);

		return $dataProvider;
	}
}
