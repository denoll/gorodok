<?php
namespace common\models\news;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\news\News;

/**
 * NewsSearch represents the model behind the search form about `common\models\News`.
 */
class NewsSearchBack extends News
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_cat', 'id_tags'], 'integer'],
            [['on_main', 'status'], 'boolean'],
            [['publish', 'unpublish', 'title', 'alias', 'subtitle', 'short_text', 'text', 'created_at', 'modifyed_at', 'autor', 'm_keyword', 'm_description', 'icon', 'thumbnail', 'images'], 'safe'],
        ];
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

        $query = News::find()->with('tags')->with('cat')->orderBy('publish DESC');



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 20,
            ],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(!empty($cat)){
            $leaves = NewsCat::getLeavesNodesByAlias($cat);
            foreach($leaves as $leav){
                $cat_id[] = $leav['id'];
            }
            $cats = implode(',',$cat_id);
            $query->andWhere('id_cat IN ('.$cats.')');
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_cat' => $this->id_cat,
            'id_tags' => $this->id_tags,
            'status' => $this->status,
            'on_main' => $this->on_main,
            'publish' => $this->publish,
            'unpublish' => $this->unpublish,
            'created_at' => $this->created_at,
            'modifyed_at' => $this->modifyed_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'subtitle', $this->subtitle])
            ->andFilterWhere(['like', 'short_text', $this->short_text])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
