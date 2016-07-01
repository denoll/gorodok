<?php

namespace common\models\firm;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\firm\Firm;

/**
 * FirmSearch represents the model behind the search form about `common\models\firm\Firm`.
 * @param string $search
 */
class FirmSearchFront extends Firm
{
	public $search;
	public $cat;
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'id_cat', 'id_user', 'status', 'show_requisites'], 'integer'],
			[['search', 'cat', 'name', 'tel', 'email', 'site', 'logo', 'description', 'created_at', 'updated_at', 'mk', 'md', 'address', 'lat', 'lon'], 'safe'],
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
		$cat = self::checking(Yii::$app->request->get('cat'));
		if(!empty($cat)){
			$_cat = FirmCat::find()->select(['id','slug','name'])->where(['slug'=>$cat])->asArray()->one();
			Yii::$app->session->set('current_cat', $_cat);
			$query = Firm::find()->with(['users', 'cat'])->where(['id_cat'=>$_cat['id']]);
		}else{
			Yii::$app->session->remove('current_cat');
			$query = Firm::find()->with(['users', 'cat']);
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

		if (!empty($params['search'])) {
			$query->andWhere('
					name        LIKE :search OR
					tel      LIKE :search OR
					email         LIKE :search OR
					site     LIKE :search OR
					address     LIKE :search OR
					description LIKE :search
					')
				->addParams([':search' => '%' . self::checking($params['search']) . '%']);

		}

		return $dataProvider;
	}

	protected static function checking($data)
	{
		$data = strip_tags($data);
		return trim($data);
	}
}
