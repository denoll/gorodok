<?php

namespace common\models\jobs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VacancySearch represents the model behind the search form about `common\models\jobs\JobVacancy`.
 */
class VacancySearch extends VVacancy
{
    public $salary_min;
    public $salary_max;
    public $education;
    public $cat;
    public $cat_i;
    public $employment;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id', 'status', 'employment', 'cat', 'cat_i'], 'integer'],
            [['email'], 'email'],
            [['salary', 'salary_min', 'salary_max',], 'number'],
            [['created_at', 'updated_at', 'vip_date', 'top_date'], 'safe'],
            [['about_company'], 'string'],
            [['username', 'avatar', 'site'], 'string', 'max' => 50],
            [['tel'], 'string', 'max' => 15],
            [['education'], 'integer'],
            [['name', 'head'], 'string', 'max' => 80],
            [['title'], 'string', 'max' => 125],
            [['description', 'address_company'], 'string', 'max' => 255],
            [['search_field'], 'string', 'max' => 499],
            [['title', 'description', 'search_field'], 'filter', 'filter' => 'strip_tags'],
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

        $query = VVacancy::find();

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
                    'asc' => ['salary' => SORT_ASC,],
                    'desc' => ['salary' => SORT_DESC,],
                    'label' => 'По зарплате',
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

        if ($this->salary_min != '' && $this->salary_max != '') {
            $sql .= ' salary >= ' . $this->salary_min . ' AND salary <= ' . $this->salary_max . ' ';
        } elseif ($this->salary_min != '' && $this->salary_max == '') {
            $sql .= ' salary >= ' . $this->salary_min . ' ';
        } elseif ($this->salary_min == '' && $this->salary_max != '') {
            $sql .= ' salary <= ' . $this->salary_max . ' ';
        }

        if (($this->salary_min != '' || $this->salary_max != '' ) && ($this->checkEdu($this->education))) {
            $sql .= ' AND ';
        }

        if ($this->checkEdu($this->education)) {
            $sql .= " (education = '" . $this->checkEdu($this->education) . "') ";
        }

        if (($this->salary_min != '' || $this->salary_max != '' || $this->checkEdu($this->education)) && $this->checkEmp($this->employment)) {
            $sql .= ' AND ';
        }

        if ($this->checkEmp($this->employment)) {
            $sql .= " (employment = '" . $this->checkEmp($this->employment) . "') ";
        }

        $arr = explode(' ', trim($this->title));
        if (($this->salary_min != '' || $this->salary_max != '' || $this->checkEdu($this->education) || $this->checkEmp($this->employment)) && (is_array($arr) && $arr[0] != '')) {
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
            $_idVac = JobCatVac::find()->where(['id_cat' => $get])->asArray()->all();
            foreach ($_idVac as $id) {
                $idVac[] = $id['id_vac'];
            }
            if (is_array($idVac)) {
                if (($this->cat != '' || $this->cat_i != '') && ($this->salary_min != '' || $this->salary_max != '' || $this->checkEdu($this->education)  || $arr[0] != '')) {
                    $sql .= ' AND ';
                }
                $id_vac = array_unique($idVac);
                $sql .= " id IN (" . implode(',', $id_vac) . ") ";
            }else{
                return false;
            }
        }else if ($this->cat != '') {
            $_idVac = JobCatVac::find()->where(['id_cat' => $this->cat])->asArray()->all();
            foreach ($_idVac as $id) {
                $idVac[] = $id['id_vac'];
            }
            if (is_array($idVac)) {
                if (($this->cat != '' || $this->cat_i != '') && ( $this->salary_min != '' || $this->salary_max != '' || $this->checkEdu($this->education) || $arr[0] != '')) {
                    $sql .= ' AND ';
                }
                $id_vac = array_unique($idVac);
                $sql .= " id IN (" . implode(',', $id_vac) . ") ";
            }else{
                return false;
            }
        }

        $query->andWhere($sql);

        return $dataProvider;
    }

    public function age($date)
    {
        $now = new \DateTimeImmutable();
        $d = new \DateTime($now->format('Y-m-d'));
        $d->sub(new \DateInterval('P' . (integer)$date . 'Y'));
        return $d->format('Y-m-d');
    }

    public function checkAge($age_min = null, $age_max = null)
    {
        if (($age_min == null && $age_max == null) || ($age_min == '' && $age_max == '')) {
            return false;
        } else if ($age_min != '' && $age_max == '') {
            return true;
        } else if ($age_min == '' && $age_max != '') {
            return true;
        } else if ($age_min != '' && $age_max != '') {
            return true;
        }
    }

    public function checkEdu($edu)
    {
        if ($edu == 0 || $edu == '' || $edu === null) {
            return false;
        } else {
            return (integer)$edu;
        }
    }

    public function checkEmp($emp)
    {
        if ($emp == 0 || $emp == '' || $emp === null) {
            return false;
        } else {
            return (integer)$emp;
        }
    }

    public function checkSex($str)
    {
        if ($str === 'm' || $str === 'f') {
            return $str;
        } else {
            return false;
        }
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
