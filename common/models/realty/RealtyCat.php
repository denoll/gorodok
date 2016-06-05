<?php
/**
 * Created by DENOLL.
 * User: Администратор
 * Date: 24.11.2015
 * Time: 4:45
 */

    namespace common\models\realty;

    use common\models\users\User;
    use Yii;
    use yii\behaviors\SluggableBehavior;

    class RealtyCat extends \kartik\tree\models\Tree
    {
        public static $treeQueryClass = '\common\models\realty\RealtyQuery';
        private static $arrSelected = ['id','alias','name','m_keyword','m_description','readonly','area_home', 'area_land', 'floor', 'floor_home', 'comfort', 'repair','resell', 'type'];
        /**
         * @inheritdoc
         */
        public function behaviors()
        {
            $behaviors = parent::behaviors();
            $behaviors[] = [
                    'class' => SluggableBehavior::className(),
                    'attribute' => 'name',
                    'slugAttribute' => 'alias',
                    'immutable' => true,
            ];
            return $behaviors;
        }
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'realty_cat';
        }

	    /**
	     * @inheritdoc
	     */
	    public function rules()
	    {
		    $rules = parent::rules();
		    $rules[] = [['m_keyword','m_description'], 'string', 'max' => 255];
            $rules[] = [['alias'], 'string', 'max' => 65];
            $rules[] = [['area_home', 'area_land', 'floor', 'floor_home', 'comfort', 'repair', 'resell', 'type'], 'integer'];
		    return $rules;
	    }

        /**
         * Override isDisabled method if you need as shown in the
         * example below. You can override similarly other methods
         * like isActive, isMovable etc.
         */
        public function isDisabled()
        {
            $isAdmin = \common\helpers\IsAdmin::init();
            if ($isAdmin::$show == 'admin') {
                $parent = false;
            }else{
                $parent = parent::isDisabled();
            }
            return $parent;
        }
        public function isReadonly()
        {
            $isAdmin = \common\helpers\IsAdmin::init();
            if ($isAdmin::$show == 'admin') {
                $parent = false;
            }else{
                $parent = parent::isReadonly();
            }
            return $parent;
        }
        public function isSelected()
        {
            $isAdmin = \common\helpers\IsAdmin::init();
            if ($isAdmin::$show == 'admin') {
                $parent = false;
            }else{
                $parent = parent::isSelected();
            }
            return $parent;
        }

        public static function setSessionCategoryTree($currentCategory = false){
            if($currentCategory){
                $current_cat = self::getCategoryByAlias($currentCategory);
                $cat_fchild = self::getFirstChildrenNodesByAlias($currentCategory);
                $cat_child = self::getChildrenNodesByAlias($currentCategory);
                $parent_cat = self::getAllParentNodesByAlias($currentCategory);
                $ses = Yii::$app->session;
                $ses->open();
                $ses->set('current_cat',$current_cat);
                $ses->set('parent_cat',$parent_cat);
                $ses->set('cat_child',$cat_child);
                $ses->set('first_child',$cat_fchild);
                $ses->close();
            }else{
                return false;
            }
        }

        public static function find()
        {
            return new RealtyQuery(get_called_class());
        }
        public static function getCategoryByAlias($alias)
        {
            return self::find()->select(self::$arrSelected)->where(['alias'=>$alias])->asArray()->one();
        }
        // получаем все корни
        public static function getAllRootsNodes()
        {
            return self::find()->roots()->select(self::$arrSelected)->asArray()->all();
        }
        // получаем все ветви
        public static function getAllLeavesNodes()
        {
            return self::find()->leaves()->select(self::$arrSelected)->asArray()->all();
        }
        // получаем ветви указанного узла по id
        public static function getLeavesNodesById($id)
        {
            $model = self::findOne(['id'=>$id]);
            return $model->leaves()->select(self::$arrSelected)->asArray()->all();
        }
        // получаем ветви указанного узла по alias
        public static function getLeavesNodesByAlias($alias)
        {
            $model = self::findOne(['alias'=>$alias]);
            return $model->leaves()->select(self::$arrSelected)->asArray()->all();
        }


        // получаем всех детей
        public static function getAllChildrenNodes()
        {
            return self::find()->children()->select(self::$arrSelected)->asArray()->all();
        }
        // получаем детей указанного узла по id
        public static function getChildrenNodesById($id)
        {
            $model = self::findOne(['id'=>$id]);
            return $model->children()->select(self::$arrSelected)->asArray()->all();
        }
        // получаем детей указанного узла по alias
        public static function getChildrenNodesByAlias($alias)
        {
            $model = self::findOne(['alias'=>$alias]);
            return $model->children()->select(self::$arrSelected)->asArray()->all();
        }

        // получаем первых детей указанного узла по id
        public static function getFirstChildrenNodesById($id)
        {
            $model = self::findOne(['id'=>$id]);
            return $model->children(1)->select(self::$arrSelected)->asArray()->all();
        }
        // получаем первых детей указанного узла по alias
        public static function getFirstChildrenNodesByAlias($alias)
        {
            $model = self::findOne(['alias'=>$alias]);
            return $model->children(1)->select(self::$arrSelected)->asArray()->all();
        }

        // получаем всех родителей указанного узла по id
        public static function getAllParentNodesById($id)
        {
            $model = self::findOne(['id'=>$id]);
            return $model->parents()->select(self::$arrSelected)->asArray()->all();
        }
        // получаем всех родителей указанного узла по alias
        public static function getAllParentNodesByAlias($alias)
        {
            $model = self::findOne(['alias'=>$alias]);
            return $model->parents()->select(self::$arrSelected)->asArray()->all();
        }

        // получаем главного родителя указанного узла по id
        public static function getFirstParentNodesById($id)
        {
            $model = self::findOne(['id'=>$id]);
            return $model->parents(1)->select(self::$arrSelected)->asArray()->all();
        }
        // получаем главного родителя указанного узла по alias
        public static function getFirstParentNodesByAlias($alias)
        {
            $model = self::findOne(['alias'=>$alias]);
            return $model->parents(1)->select(self::$arrSelected)->asArray()->all();
        }
    }