<?php
namespace common\models\letters;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\letters\Letters;

/**
 * LettersSearch represents the model behind the search form about `common\models\Letters`.
 */
class LettersSearchBack extends Letters
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

        $query = Letters::find()->with('tags')->with('cat')->orderBy('publish DESC');



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

        if(!empty($cat)){
            $leaves = LettersCat::getLeavesNodesByAlias($cat);
            foreach($leaves as $leav){
                $cat_id[] = $leav['id'];
            }
            $cats = implode(',',$cat_id);
            $query->andWhere('id_cat IN ('.$cats.')');
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
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'subtitle', $this->title])
            ->andFilterWhere(['like', 'short_text', $this->title])
            ->andFilterWhere(['like', 'text', $this->title]);

        return $dataProvider;
    }
}
