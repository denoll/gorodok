<?php
namespace common\models\afisha;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\afisha\Afisha;

/**
 * AfishaSearch represents the model behind the search form about `common\models\Afisha`.
 */
class AfishaSearchBack extends Afisha
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_cat', 'id_place'], 'integer'],
            [['on_main', 'status'], 'boolean'],
            [['publish', 'unpublish', 'title', 'alias', 'subtitle', 'short_text', 'text', 'created_at', 'updated_at', 'autor', 'm_keyword', 'm_description', 'icon', 'thumbnail', 'images','date_in','date_out'], 'safe'],
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

        $query = Afisha::find()->with('tags')->with('cat')->orderBy('publish DESC');



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
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_cat' => $this->id_cat,
            'id_place' => $this->id_place,
            'status' => $this->status,
            'on_main' => $this->on_main,
            'publish' => $this->publish,
            'unpublish' => $this->unpublish,
            'date_in' => $this->date_in,
            'date_out' => $this->date_out,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'subtitle', $this->subtitle])
            ->andFilterWhere(['like', 'short_text', $this->short_text])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
