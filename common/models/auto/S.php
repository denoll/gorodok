<?php

namespace common\models\auto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\auto\AutoItem;

/**
 * ItemSearch represents the model behind the search form about `common\models\auto\AutoItem`.
 *
 * @property string $price_min
 * @property string $price_max
 * @property integer $year_min
 * @property integer $year_max
 * @property integer $distance_min
 * @property integer $distance_max
 * @property integer $volume_min
 * @property integer $volume_max
 * @property integer $power_min
 * @property integer $power_max
 */
class S extends AutoItem
{

	public $price_min;
	public $price_max;
	public $year_min;
	public $year_max;
	public $distance_min;
	public $distance_max;
	public $volume_min;
	public $volume_max;
	public $power_min;
	public $power_max;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'id_user', 'id_model', 'id_brand', 'id_modify', 'status', 'order', 'new', 'body', 'transmission', 'distance',
				'customs', 'stage', 'crash', 'door', 'motor', 'privod'], 'integer'],
			[['year', 'year_min', 'year_max'],'integer'],
			[['distance', 'distance_min', 'distance_max'],'integer'],
			[['power', 'power_min', 'power_max'],'integer'],
			[['created_at', 'updated_at', 'top_date', 'vip_date', 'color'], 'safe'],
			[['price', 'price_min', 'price_max'], 'number'],
			[['volume', 'volume_min', 'volume_max'], 'number'],
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
		$query = AutoItem::find()->with(['userActive', 'autoImg', 'model', 'brand'])->andWhere(['status' => AutoItem::STATUS_ACTIVE]);

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
				'price' => [
					'asc' => ['price' => SORT_ASC,],
					'desc' => ['price' => SORT_DESC,],
					'label' => 'по цене',
				],
				'year' => [
					'asc' => ['year' => SORT_ASC,],
					'desc' => ['year' => SORT_DESC,],
					'label' => 'по году выпуска',
				],
				'created_at' => [
					'asc' => ['created_at' => SORT_ASC,],
					'desc' => ['created_at' => SORT_DESC,],
					'label' => 'по дате',
				],
			],
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
		//новая с пробегом или все
		if(!empty($this->new) && $this->new != 0){
			$query->andFilterWhere(['new' => $this->new]);
		}
		//бренд и модель
		if(!empty($this->id_brand)){
			$query->andFilterWhere(['id_brand' => $this->id_brand]);
		}
		if(!empty($this->id_model)){
			$query->andFilterWhere(['id_model' => $this->id_model]);
		}
		//кузов и коробка
		if(!empty($this->body)){
			$query->andFilterWhere(['body' => $this->body]);
		}
		if(!empty($this->transmission)){
			$query->andFilterWhere(['transmission' => $this->transmission]);
		}
		//цена
		if(!empty($this->price_min)){
			$query->andFilterWhere(['>=','price',$this->price_min]);
		}
		if(!empty($this->price_max)){
			$query->andFilterWhere(['<=','price',$this->price_max]);
		}
		//год
		if(!empty($this->year_min)){
			$query->andFilterWhere(['>=','year',$this->year_min]);
		}
		if(!empty($this->year_max)){
			$query->andFilterWhere(['<=','year',$this->year_max]);
		}
		//пробег
		if(!empty($this->distance_min)){
			$query->andFilterWhere(['>=','distance',$this->distance_min]);
		}
		if(!empty($this->distance_max)){
			$query->andFilterWhere(['<=','distance',$this->distance_max]);
		}
		//Объем двигателя
		if(!empty($this->volume_min)){
			$query->andFilterWhere(['>=','volume',$this->volume_min]);
		}
		if(!empty($this->volume_max)){
			$query->andFilterWhere(['<=','volume',$this->volume_max]);
		}
		//Мощность двигателя
		if(!empty($this->power_min)){
			$query->andFilterWhere(['>=','power',$this->power_min]);
		}
		if(!empty($this->power_max)){
			$query->andFilterWhere(['<=','power',$this->power_max]);
		}
		//Тип двигателя и цвет авто
		if(!empty($this->motor)){
			$query->andFilterWhere(['motor'=>$this->motor]);
		}
		if(!empty($this->color)){
			$query->andFilterWhere(['color'=>$this->color]);
		}

		// grid filtering conditions
		$query->andFilterWhere([

			'customs' => $this->customs,
			'stage' => $this->stage,
			'crash' => $this->crash,
			'door' => $this->door,
			'privod' => $this->privod,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'top_date' => $this->top_date,
			'vip_date' => $this->vip_date,
		]);

		$query->andFilterWhere(['like', 'vin', $this->vin])
			->andFilterWhere(['like', 'description', $this->description])
			->andFilterWhere(['like', 'mk', $this->mk])
			->andFilterWhere(['like', 'md', $this->md]);

		return $dataProvider;
	}
}
