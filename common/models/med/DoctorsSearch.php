<?php

namespace common\models\med;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DoctorsSearch represents the model behind the search form about `common\models\med\Doctors`.
 */
class DoctorsSearch extends VDoctors
{
    public $exp_min; //Стаж
    public $exp_max;
    public $price_min; //Стоимость приема
    public $price_max;
    public $cat; //Специализация
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_spec', 'status', 'confirmed', 'exp', 'receiving', 'exp_min', 'exp_max', 'cat', 'doctor'], 'integer'],
            [['updated_at', 'created_at',], 'safe'],
            [['price','price_min','price_max'], 'number'],
            [['rank', 'about', 'address', 'documents', 'search_field', 'spec','m_keyword','m_description'], 'string'],
            [['rank', 'about', 'address', 'documents', 'search_field', 'spec','m_keyword','m_description'], 'filter', 'filter'=>'strip_tags'],
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
        $query = VDoctors::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => SORT_DESC,
                ],

            ],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'salary' => [
                    'asc' => ['exp' => SORT_ASC,],
                    'desc' => ['exp' => SORT_DESC,],
                    'label' => 'По стажу работы',
                ],
                'updated_at' => [
                    'asc' => ['updated_at' => SORT_ASC,],
                    'desc' => ['updated_at' => SORT_DESC,],
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

        $sql = '';

        if ($this->exp_min != '' && $this->exp_max != '') {
            $sql .= ' exp >= ' . $this->exp_min . ' AND exp <= ' . $this->exp_max . ' ';
        } elseif ($this->exp_min != '' && $this->exp_max == '') {
            $sql .= ' exp >= ' . $this->exp_min . ' ';
        } elseif ($this->exp_min == '' && $this->exp_max != '') {
            $sql .= ' exp <= ' . $this->exp_max . ' ';
        }

        $arr = explode(' ', trim($this->search_field));
        if (($this->exp_min != '' || $this->exp_max != '') && (is_array($arr) && $arr[0] != '')) {
            $sql .= ' AND ';
        }

        if (is_array($arr) && $arr[0] != '') {
            $a = $arr;
            $len = count($a);
            foreach ($arr as $k => $item) {
                $_item = "'%" . $this->ingSafe($item) . "%'";
                if ($k === 0) {
                    $l = $len > 1 ? '(' : '';
                    $sql .= " " . $l . "search_field LIKE " . $_item;
                } else {
                    $s = ($len - 1) == $k ? ")" : "";
                    $sql .= " OR search_field LIKE " . $_item . $s;
                }
            }
        }

        $get = \Yii::$app->request->get('cat');

        if($get){
            $spec = Spec::find()->where(['id' => $get])->asArray()->one();
            if (is_array($spec)) {
                if (($get != '') && ($this->exp_min != '' || $this->exp_max != '' || $arr[0] != '')) {
                    $sql .= ' AND ';
                }
                $idSpec = $spec['id'];
                $sql .= "id_spec = $idSpec";
            }else{
                return false;
            }
        }else if ($this->cat != '') {
            $spec = Spec::find()->where(['id' => $this->cat])->asArray()->one();
            if (is_array($spec)) {
                if (($this->cat != '') && ($this->exp_min != '' || $this->exp_max != '' || $arr[0] != '')) {
                    $sql .= ' AND ';
                }
                $idSpec = $spec['id'];
                $sql .= "id_spec = $idSpec";
            }else{
                return false;
            }
        }



        $query->andWhere($sql);
        if(!empty($this->price_min)){
            $query->andWhere(['>','price',$this->price_min]);
        }
        if(!empty($this->price_max)){
            $query->andWhere(['<','price',$this->price_max]);
        }
        return $dataProvider;

    }

    public function ingSafe($text_to_check)
    {
        $text_to_check = strip_tags($text_to_check);
        $text_to_check = htmlspecialchars($text_to_check);
        $text_to_check = stripslashes($text_to_check);
        $text_to_check = addslashes($text_to_check);

        return $text_to_check;
    }
}
