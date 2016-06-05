<?php

namespace common\models\jobs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\jobs\VResume;

/**
 * JobResumeSearch represents the model behind the search form about `common\models\jobs\JobResume`.
 */
class JobResumeSearch extends VResume
{
    public $salary_min;
    public $salary_max;
    public $age_min;
    public $age_max;
    public $cat;
    public $cat_i;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'status', 'education', 'employment', 'cat', 'cat_i'], 'integer'],
            [['salary', 'salary_min', 'salary_max', 'age_min', 'age_max'], 'number'],
            [['updated_at', 'created_at', 'vip_date', 'birthday'], 'safe'],
            [['skills', 'about', 'search_field'], 'string'],
            [['username', 'email', 'description'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 15],
            [['fio'], 'string', 'max' => 152],
            [['avatar'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 125],
            [['sex'], 'string', 'max' => 1],
            [['title', 'description', 'fio'], 'filter', 'filter' => 'strip_tags'],
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

        $query = VResume::find();

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

        if ($this->checkAge($this->age_min, $this->age_max) && ($this->salary_min != '' || $this->salary_max != '')) {
            $sql .= ' AND ';
        }

        if ($this->age_min != '' && $this->age_max != '') {
            $sql .= " birthday <= '" . $this->age($this->age_min) . "' AND birthday >= '" . $this->age($this->age_max) . "' ";
        } elseif ($this->age_min != '' && $this->age_max == '') {
            $sql .= " birthday <= '" . $this->age($this->age_min) . "' ";
        } elseif ($this->age_min == '' && $this->age_max != '') {
            $sql .= " birthday >= '" . $this->age($this->age_max) . "' ";
        }

        if (($this->salary_min != '' || $this->salary_max != '' || $this->checkAge($this->age_min, $this->age_max)) && ($this->checkSex($this->sex))) {
            $sql .= ' AND ';
        }

        if ($this->checkSex($this->sex)) {
            $sql .= " (sex = '" . $this->checkSex($this->sex) . "') ";
        }

        if (($this->salary_min != '' || $this->salary_max != '' || $this->checkSex($this->sex) || $this->checkAge($this->age_min, $this->age_max)) && ($this->checkEdu($this->education))) {
            $sql .= ' AND ';
        }

        if ($this->checkEdu($this->education)) {
            $sql .= " (education = '" . $this->checkEdu($this->education) . "') ";
        }

        if (($this->salary_min != '' || $this->salary_max != '' || $this->checkSex($this->sex) || $this->checkEdu($this->education) || $this->checkAge($this->age_min, $this->age_max)) && $this->checkEmp($this->employment)) {
            $sql .= ' AND ';
        }

        if ($this->checkEmp($this->employment)) {
            $sql .= " (employment = '" . $this->checkEmp($this->employment) . "') ";
        }

        $arr = explode(' ', trim($this->title));
        if (($this->salary_min != '' || $this->salary_max != '' || $this->checkSex($this->sex) || $this->checkEdu($this->education) || $this->checkAge($this->age_min, $this->age_max) || $this->checkEmp($this->employment)) && (is_array($arr) && $arr[0] != '')) {
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
            $_idRes = JobCatRez::find()->where(['id_cat' => $get])->asArray()->all();
            if (!empty($_idRes)) {
                foreach ($_idRes as $id) {
                    $idRes[] = $id['id_res'];
                }

                $id_res = array_unique($idRes);
                if(!empty($id_res[0])){
                if (($this->cat != '' || $this->cat_i != '') && ($this->checkAge($this->age_min, $this->age_max) || $this->salary_min != '' || $this->salary_max != '' || $this->checkEdu($this->education) || $this->checkSex($this->sex) || $arr[0] != '')) {
                    $sql .= ' AND ';
                }
                    $sql .= " id IN (" . implode(',', $id_res) . ") ";
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else if ($this->cat != '') {
            $_idRes = JobCatRez::find()->where(['id_cat' => $this->cat])->asArray()->all();
            if (!empty($_idRes)) {
                foreach ($_idRes as $id) {
                    $idRes[] = $id['id_res'];
                }
                $id_res = array_unique($idRes);
                if(!empty($id_res[0])){
                if (($this->cat != '' || $this->cat_i != '') && ($this->checkAge($this->age_min, $this->age_max) || $this->salary_min != '' || $this->salary_max != '' || $this->checkEdu($this->education) || $this->checkSex($this->sex) || $arr[0] != '')) {
                    $sql .= ' AND ';
                }
                    $sql .= " id IN (" . implode(',', $id_res) . ") ";
                }else{
                    return false;
                }
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
