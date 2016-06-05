<?php

namespace common\models\realty;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\realty\VRealtyRent;

/**
 * RealtyRentSearch represents the model behind the search form about `common\models\realty\RealtyRent`.
 */
class RealtyRentSearch extends VRealtyRent
{
    public $cost_min; //DECIMAL
    public $cost_max; //DECIMAL
    public $cat;
    public $alias;
    public $area_home_min; //DECIMAL
    public $area_home_max; //DECIMAL
    public $area_land_min;  //DECIMAL
    public $area_land_max;  //DECIMAL
    public $floor_min; //INT
    public $floor_max; //INT
    public $floor_home_min; //INT
    public $floor_home_max; //INT
    public $distance_min; //DECIMAL
    public $distance_max; //DECIMAL


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_cat', 'status', 'floor', 'floor_min', 'floor_max', 'floor_home', 'floor_home_min', 'floor_home_max', 'resell', 'in_city', 'u_status', 'company', 'type', 'elec', 'gas', 'water', 'heating', 'tel_line', 'internet', 'repair'], 'integer'],
            [['cost', 'cost_min', 'cost_max', 'area_home','area_home_min','area_home_max','area_land','area_land_min','area_land_max','distance','distance_min','distance_max'], 'number'],
            [['description', 'search_field'], 'string'],
            [['vip_date', 'adv_date', 'updated_at', 'created_at'], 'safe'],
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
        $get = \Yii::$app->request->get('cat');
        if(!empty($get)|| !empty($this->cat)){
            $_cat = !empty($get) ? $get : $this->cat;
            RealtyCat::setSessionCategoryTree($_cat);
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
        if(isset($cur_cat)){
            foreach($cat as $item) {
                $id_cat[] = $item['id'];
            }
            if(is_array($id_cat)){
                $id_str = implode(',',$id_cat);
                $query = VRealtyRent::find()->where("id_cat IN ($id_str)");
            }else{
                $query = VRealtyRent::find()->where(['id_cat' => $id_cat]);
            }
        }else{
            $query = VRealtyRent::find();
        }

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
        $arr = explode(' ', trim($this->search_field));

        if ($this->cost_min != '' && $this->cost_max != '') {
            $sql .= ' cost >= ' . $this->cost_min . ' AND cost <= ' . $this->cost_max . ' ';
        } elseif ($this->cost_min != '' && $this->cost_max == '') {
            $sql .= ' cost >= ' . $this->cost_min . ' ';
        } elseif ($this->cost_min == '' && $this->cost_max != '') {
            $sql .= ' cost <= ' . $this->cost_max . ' ';
        }
        if (($this->cost_min != '' || $this->cost_max != '')&&($this->distance_min != '' || $this->distance_max != '')){
            $sql .= ' AND ';
        }

        if ($this->distance_min != '' && $this->distance_max != '') {
            $sql .= ' distance >= ' . $this->distance_min . ' AND distance <= ' . $this->distance_max . ' ';
        } elseif ($this->distance_min != '' && $this->distance_max == '') {
            $sql .= ' distance >= ' . $this->distance_min . ' ';
        } elseif ($this->distance_min == '' && $this->distance_max != '') {
            $sql .= ' distance <= ' . $this->distance_max . ' ';
        }
        if ((($this->cost_min != '' || $this->cost_max != '')||($this->distance_min != '' || $this->distance_max != ''))&&($this->area_home_min != '' || $this->area_home_max != '')){
            $sql .= ' AND ';
        }
        if ($this->area_home_min != '' && $this->area_home_max != '') {
            $sql .= ' area_home >= ' . $this->area_home_min . ' AND area_home <= ' . $this->area_home_max . ' ';
        } elseif ($this->area_home_min != '' && $this->area_home_max == '') {
            $sql .= ' area_home >= ' . $this->area_home_min . ' ';
        } elseif ($this->area_home_min == '' && $this->area_home_max != '') {
            $sql .= ' area_home <= ' . $this->area_home_max . ' ';
        }
        if ((($this->cost_min != '' || $this->cost_max != '')||($this->distance_min != '' || $this->distance_max != '')||($this->area_home_min != '' || $this->area_home_max != ''))&&($this->area_land_min != '' || $this->area_land_max != '')){
            $sql .= ' AND ';
        }
        if ($this->area_land_min != '' && $this->area_land_max != '') {
            $sql .= ' area_land >= ' . $this->area_land_min . ' AND area_land <= ' . $this->area_land_max . ' ';
        } elseif ($this->area_land_min != '' && $this->area_land_max == '') {
            $sql .= ' area_land >= ' . $this->area_land_min . ' ';
        } elseif ($this->area_land_min == '' && $this->area_land_max != '') {
            $sql .= ' area_land <= ' . $this->area_land_max . ' ';
        }
        if ((($this->cost_min != '' || $this->cost_max != '')||($this->distance_min != '' || $this->distance_max != '')||($this->area_home_min != '' || $this->area_home_max != '')||($this->area_land_min != '' || $this->area_land_max != ''))&&($this->floor_min != '' || $this->floor_max != '')){
            $sql .= ' AND ';
        }
        if ($this->floor_min != '' && $this->floor_max != '') {
            $sql .= ' floor >= ' . $this->floor_min . ' AND floor <= ' . $this->floor_max . ' ';
        } elseif ($this->floor_min != '' && $this->floor_max == '') {
            $sql .= ' floor >= ' . $this->floor_min . ' ';
        } elseif ($this->floor_min == '' && $this->floor_max != '') {
            $sql .= ' floor <= ' . $this->floor_max . ' ';
        }
        if ((($this->cost_min != '' || $this->cost_max != '')||($this->distance_min != '' || $this->distance_max != '')||($this->area_home_min != '' || $this->area_home_max != '')||($this->area_land_min != '' || $this->area_land_max != '')||($this->floor_min != '' || $this->floor_max != ''))&&($this->floor_home_min != '' || $this->floor_home_max != '')){
            $sql .= ' AND ';
        }
        if ($this->floor_home_min != '' && $this->floor_home_max != '') {
            $sql .= ' floor_home >= ' . $this->floor_home_min . ' AND floor_home <= ' . $this->floor_home_max . ' ';
        } elseif ($this->floor_home_min != '' && $this->floor_home_max == '') {
            $sql .= ' floor_home >= ' . $this->floor_home_min . ' ';
        } elseif ($this->floor_home_min == '' && $this->floor_home_max != '') {
            $sql .= ' floor_home <= ' . $this->floor_home_max . ' ';
        }

        if (is_array($arr) && $arr[0] != '' && (($this->cost_min != '' || $this->cost_max != '')||($this->distance_min != '' || $this->distance_max != '')||($this->area_home_min != '' || $this->area_home_max != '')||($this->area_land_min != '' || $this->area_land_max != '')||($this->floor_min != '' || $this->floor_max != '')||($this->floor_home_min != '' || $this->floor_home_max != ''))) {
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

        if ($this->cat != '') {
            $cat = RealtyCat::getChildrenNodesByAlias($this->cat);
            print_r($cat);
            if (is_array($cat)) {
                if (($this->cat != '') && (($this->cost_min != '' || $this->cost_max != '')||($this->distance_min != '' || $this->distance_max != '')||($this->area_home_min != '' || $this->area_home_max != '')||($this->area_land_min != '' || $this->area_land_max != '')||($this->floor_min != '' || $this->floor_max != '')||($this->floor_home_min != '' || $this->floor_home_max != '')||(is_array($arr) && $arr[0] != ''))) {
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
            }else{
                return false;
            }
        }
        echo $sql;
        $query->andWhere($sql);
        if($this->resell != ''){$query->andWhere(['resell'=>$this->resell]);}
        if($this->repair != ''){$query->andWhere(['repair'=>$this->repair]);}
        if($this->type != ''){$query->andWhere(['type'=>$this->type]);}
        if($this->elec != ''){$query->andWhere(['elec'=>$this->elec]);}
        if($this->gas != ''){$query->andWhere(['gas'=>$this->gas]);}
        if($this->water != ''){$query->andWhere(['water'=>$this->water]);}
        if($this->heating != ''){$query->andWhere(['heating'=>$this->heating]);}
        if($this->tel_line != ''){$query->andWhere(['tel_line'=>$this->tel_line]);}
        if($this->internet != ''){$query->andWhere(['internet'=>$this->internet]);}

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
