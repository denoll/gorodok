<?php
namespace common\models\letters;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\letters\Letters;

/**
 * LettersSearch represents the model behind the search form about `common\models\Letters`.
 */
class LettersSearch extends Letters
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'id_cat', 'id_user'], 'integer'],
			[['on_main', 'status'], 'boolean'],
			[['publish', 'unpublish', 'title', 'alias', 'subtitle', 'short_text', 'text', 'created_at', 'updated_at', 'author', 'm_keyword', 'm_description', 'icon', 'thumbnail', 'images'], 'safe'],
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
		$cat = \Yii::$app->request->get('cat');
		if ($this->load($params) || !empty($cat)) {
			$query = Letters::find()->with('tags')->with('cat')->where('((unpublish < NOW())OR(unpublish IS NULL))')->andWhere(['status' => 1])->orderBy('publish DESC');
		} else {
			$query = Letters::find()->with('tags')->with('cat')->where('((unpublish < NOW())OR(unpublish IS NULL))')->andWhere(['status' => 1, 'on_main' => 1])->orderBy('publish DESC');
		}


		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'forcePageParam' => false,
				'pageSizeParam' => false,
				'pageSize' => 20,
			],
		]);
		//$dataProvider->sort->enableMultiSort = true;
		//$dataProvider->sort->defaultOrder = ['publish' => SORT_DESC,];
		$dataProvider->setSort([
			'attributes' => [
				'publish' => [
					'asc' => ['publish' => SORT_ASC,],
					'desc' => ['publish' => SORT_DESC,],
					'label' => 'По дате',
				],
				'rating' => [
					'asc' => ['rating' => SORT_ASC,],
					'desc' => ['rating' => SORT_DESC,],
					'label' => 'По рейтингу',
				],
			],
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		if (!empty($cat)) {
			LettersCat::setSessionCategoryTree($cat);
			$leaves = LettersCat::getLeavesNodesByAlias($cat);
			$cur_cat = LettersCat::findOne(['alias' => $cat]);
			$cat_id[] = $cur_cat->id;
			if (!empty($leaves[0])) {
				foreach ($leaves as $leave) {
					$cat_id[] = $leave['id'];
				}
			}
			$cats = implode(',', $cat_id);
			$query->andWhere('id_cat IN (' . $cats . ')');
		}

		$query->andFilterWhere([
			'id' => $this->id,
			'id_cat' => $this->id_cat,
			'id_user' => $this->id_user,
			'status' => $this->status,
			'on_main' => $this->on_main,
			'publish' => $this->publish,
			'unpublish' => $this->unpublish,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		]);

		$query->andFilterWhere(['like', 'title', $this->title])
			->orFilterWhere(['like', 'short_text', $this->title]);

		return $dataProvider;
	}
}
