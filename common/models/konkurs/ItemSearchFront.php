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
			[['id', 'id_konkurs', 'id_user', 'status', 'yes', 'no', 'vote_count'], 'integer'],
			[['scope'],'number'],
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
	 * @param array $params
	 * @param integer $id_konkurs
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params, $id_konkurs = null, $onlyActive = true)
	{
		if($onlyActive){
			$query = KonkursItem::find()->with(['user', 'konkurs', 'vote'])->where(['id_konkurs' => $id_konkurs, 'status'=>KonkursItem::STATUS_ACTIVE]);
		}else{
			$query = KonkursItem::find()->with(['user', 'konkurs', 'vote'])->where(['id_konkurs' => $id_konkurs])->andWhere(['<>','status',KonkursItem::STATUS_DISABLE]);
		}
		$user_id = Yii::$app->request->get('user');
		if(!empty($user_id)){
			$query->andWhere(['id_user' => (int)$user_id]);
		}

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
				'scope_desc' => [
					'attribute' => 'scope',
					'asc' => ['scope' => SORT_DESC,],
					'desc' => ['scope' => SORT_ASC,],
					'label' => 'первые места',
				],
				'scope_asc' => [
					'attribute' => 'scope',
					'asc' => ['scope' => SORT_ASC,],
					'desc' => ['scope' => SORT_DESC,],
					'label' => 'последние места',
				],

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
			'vote_count' => $this->vote_count,
		]);

		$query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'description', $this->description]);

		$search = Yii::$app->request->get('search');
		if(!empty($search)){
			$search = $this->check($search);
			$search = $this->getSearchArray($search);
			$sql = '';

			foreach ($search as $i => $item){
				if($i !== 0) $sql .= ' OR ';
				$sql .= '`name` LIKE \'%'.$item.'%\' ';
				$sql .= ' OR ';
				$sql .= '`description` LIKE \'%'.$item.'%\' ';
			}
			$query->andWhere(
				$sql
			);
		}

		return $dataProvider;
	}

	protected function check($str){
		$arr = [',','.',':',';','_','"','\'','+','\\'];
		$str = str_replace($arr, ' ',$str);
		$str = strip_tags($str);
		return trim($str);
	}

	protected function getSearchArray($str){
		return explode(' ',$str);
	}
}
