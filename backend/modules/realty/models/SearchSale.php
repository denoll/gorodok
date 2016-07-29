<?php

namespace app\modules\realty\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\realty\RealtySale;

/**
 * SearchSale represents the model behind the search form about `common\models\realty\RealtySale`.
 *
 * @param string $category
 * @param string $username
 */
class SearchSale extends VbRealtySale
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[ [ 'id', 'id_cat', 'id_user', 'status', 'floor', 'floor_home', 'resell', 'in_city', 'type', 'repair', 'elec', 'gas', 'water', 'heating', 'tel_line', 'internet', 'count_img' ], 'integer' ],
			[ [ 'name', 'main_img', 'address', 'description', 'created_at', 'updated_at', 'vip_date', 'adv_date', 'm_keyword', 'm_description', 'category', 'username' ], 'safe' ],
			[ [ 'cost', 'area_home', 'area_land', 'distance' ], 'number' ],
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
		$query = VbRealtySale::find();

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if ( !$this->validate() ) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			'id'         => $this->id,
			'id_cat'     => $this->id_cat,
			'id_user'    => $this->id_user,
			'status'     => $this->status,
			'cost'       => $this->cost,
			'area_home'  => $this->area_home,
			'area_land'  => $this->area_land,
			'floor'      => $this->floor,
			'floor_home' => $this->floor_home,
			'resell'     => $this->resell,
			'in_city'    => $this->in_city,
			'type'       => $this->type,
			'repair'     => $this->repair,
			'elec'       => $this->elec,
			'gas'        => $this->gas,
			'water'      => $this->water,
			'heating'    => $this->heating,
			'tel_line'   => $this->tel_line,
			'internet'   => $this->internet,
			'distance'   => $this->distance,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'vip_date'   => $this->vip_date,
			'adv_date'   => $this->adv_date,
			'count_img'  => $this->count_img,
			'category'   => $this->category,
			'username'   => $this->username,
		]);

		$query->andFilterWhere([ 'like', 'name', $this->name ])
			->andFilterWhere([ 'like', 'main_img', $this->main_img ])
			->andFilterWhere([ 'like', 'address', $this->address ])
			->andFilterWhere([ 'like', 'description', $this->description ])
			->andFilterWhere([ 'like', 'm_keyword', $this->m_keyword ])
			->andFilterWhere([ 'like', 'm_description', $this->m_description ]);

		return $dataProvider;
	}
}
