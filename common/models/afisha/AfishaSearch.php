<?php
namespace common\models\afisha;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\afisha\Afisha;

/**
 * AfishaSearch represents the model behind the search form about `common\models\Afisha`.
 */
class AfishaSearch extends Afisha
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
        if($this->load($params) || !empty($cat)){
            $query = Afisha::find()->with('tags')->with('cat')->with('place')->where('(publish < NOW() AND (unpublish < NOW()OR unpublish IS NULL))')->andWhere(['status'=>1])->orderBy('publish DESC');
        }else{
            $query = Afisha::find()->with('tags')->with('cat')->with('place')->where('(publish < NOW() AND (unpublish < NOW()OR unpublish IS NULL))')->andWhere(['status'=>1,'on_main'=>1])->orderBy('publish DESC');
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
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(!empty($cat)){
            AfishaCat::setSessionCategoryTree($cat);
            $leaves = AfishaCat::getLeavesNodesByAlias($cat);
            foreach($leaves as $leav){
                $cat_id[] = $leav['id'];
            }
            $cats = implode(',',$cat_id);
            $query->andWhere('id_cat IN ('.$cats.')');
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_cat' => $this->id_cat,
            'id_place' => $this->id_place,
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
