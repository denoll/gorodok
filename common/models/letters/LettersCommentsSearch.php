<?php
namespace common\models\letters;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\letters\LettersComments;

/**
 * LettersCommentsSearch represents the model behind the search form about `common\models\LettersComments`.
 */
class LettersCommentsSearch extends LettersComments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'id_user', 'id_letter', 'status'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
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
        $id = \Yii::$app->request->get('id');
        if(!empty($id)){
            $query = LettersComments::find()->with('user')->where(['id_letter'=>$id])->orderBy('created_at DESC');
        }else{
            $query = LettersComments::find()->with('user')->orderBy('created_at DESC');
        }


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
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC,],
                    'desc' => ['created_at' => SORT_DESC,],
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
            'id_letter' => $this->id_letter,
            'id_user' => $this->id_user,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
