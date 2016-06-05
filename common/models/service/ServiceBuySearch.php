<?php

namespace common\models\service;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\service\VServiceBuy;

/**
 * ServiceSearch represents the model behind the search form about `common\models\service\Service`.
 */
class ServiceBuySearch extends VService
{
    public $cost_min;
    public $cost_max;
    public $cat;
    public $alias;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_cat', 'status', 'u_status', 'company'], 'integer'],
            [['cost', 'cost_min', 'cost_max'], 'number'],
            [['description', 'search_field'], 'string'],
            [['vip_date', 'top_date', 'updated_at', 'created_at'], 'safe'],
            [['category', 'cat', 'alias'], 'string', 'max' => 65],
            [['name', 'main_img', 'username', 'email'], 'string', 'max' => 50],
            [['m_keyword', 'm_description'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 15],
            [['fio'], 'string', 'max' => 152],
            [['category', 'cat', 'alias', 'search_field', 'cost_min', 'cost_max'], 'filter', 'filter' => 'strip_tags'],
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
        $query = VServiceBuy::find()->with('tags')->asArray();

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
                'cost' => [
                    'asc' => ['cost' => SORT_ASC,],
                    'desc' => ['cost' => SORT_DESC,],
                    'label' => 'По цене',
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

        if ($this->cost_min != '' && $this->cost_max != '') {
            $sql .= ' cost >= ' . $this->cost_min . ' AND cost <= ' . $this->cost_max . ' ';
        } elseif ($this->cost_min != '' && $this->cost_max == '') {
            $sql .= ' cost >= ' . $this->cost_min . ' ';
        } elseif ($this->cost_min == '' && $this->cost_max != '') {
            $sql .= ' cost <= ' . $this->cost_max . ' ';
        }

        $arr = explode(' ', trim($this->search_field));
        if (($this->cost_min != '' || $this->cost_max != '') && (is_array($arr) && $arr[0] != '')) {
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
        if(!empty($get)|| !empty($this->cat)){
            $_cat = !empty($get) ? $get : $this->cat;
            ServiceCat::setSessionCategoryTree($_cat);
            $ses = Yii::$app->session;
            $ses->open();
            $cur_cat = $ses->get('current_cat');
            $cat_child = $ses->get('cat_child');
            $ses->close();
            if(!empty($cat_child)){
                $cat = $cat_child;
            }else{
                $cat[0] = $cur_cat;
            }

        }

        if($get){
            if (!empty($cat)) {
                if (($get != '') && ($this->cost_min != '' || $this->cost_max != '' || $arr[0] != '')) {
                    $sql .= ' AND ';
                }
                foreach($cat as $item) {
                    $id_cat[] = $item['id'];
                }
                if(is_array($id_cat)){
                    $id_str = implode(',',$id_cat);
                    $sql .= "id_cat IN ($id_str)";
                }else{
                    $sql .= "id_cat = $id_cat";
                }
            }
        }else if ($this->cat != '') {
            if (is_array($cat)) {
                if (($this->cat != '') && ($this->cost_min != '' || $this->cost_max != '' || $arr[0] != '')) {
                    $sql .= ' AND ';
                }
                $idCat = $cat[0]['id'];
                $sql .= "id_cat = $idCat";
            }else{
                return false;
            }
        }
        $query->andWhere($sql);
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
