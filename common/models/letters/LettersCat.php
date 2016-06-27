<?php
namespace common\models\letters;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "letters_cat".
 *
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $lvl
 * @property string $name
 * @property string $icon
 * @property integer $icon_type
 * @property integer $active
 * @property integer $selected
 * @property integer $disabled
 * @property integer $readonly
 * @property integer $visible
 * @property integer $collapsed
 * @property integer $movable_u
 * @property integer $movable_d
 * @property integer $movable_l
 * @property integer $movable_r
 * @property integer $removable
 * @property integer $removable_all
 *
 * @property Letters[] $letters
 */
class LettersCat extends \kartik\tree\models\Tree
{
	const DEPENDENCY_TIME = 3600;
	private static $alias;
	private static $id;

	public static $treeQueryClass = '\common\models\service\ServiceQuery';
	private static $arrSelected = ['id', 'alias', 'name', 'm_keyword', 'm_description'];

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
		return 'letters_cat';

	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		$rules = parent::rules();
		$rules[] = [['m_keyword', 'm_description'], 'string', 'max' => 255];
		$rules[] = [['alias'], 'string', 'max' => 65];
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
		} else {
			$parent = parent::isDisabled();
		}
		return $parent;
	}

	public function isReadonly()
	{
		$isAdmin = \common\helpers\IsAdmin::init();
		if ($isAdmin::$show == 'admin') {
			$parent = false;
		} else {
			$parent = parent::isReadonly();
		}
		return $parent;
	}

	public function isSelected()
	{
		$isAdmin = \common\helpers\IsAdmin::init();
		if ($isAdmin::$show == 'admin') {
			$parent = false;
		} else {
			$parent = parent::isSelected();
		}
		return $parent;
	}

	public static function setSessionCategoryTree()
	{
		$get = Yii::$app->request->get();
		if (!empty($get['cat']) && isset($get['cat'])) {
			$currentCategory = $get['cat'];
		} elseif (!empty($get['ServiceSearch']['cat']) && isset($get['ServiceSearch']['cat'])) {
			$currentCategory = $get['ServiceSearch']['cat'];
		} elseif (!empty($get['ServiceBuySearch']['cat']) && isset($get['ServiceBuySearch']['cat'])) {
			$currentCategory = $get['ServiceBuySearch']['cat'];
		} else {
			$currentCategory = false;
		}
		if ($currentCategory) {
			$current_cat = self::getCategoryByAlias($currentCategory);
			$cat_fchild = self::getFirstChildrenNodesByAlias($currentCategory);
			$cat_child = self::getChildrenNodesByAlias($currentCategory);
			$parent_cat = self::getAllParentNodesByAlias($currentCategory);
			$ses = Yii::$app->session;
			$ses->open();
			$ses->set('current_cat', $current_cat);
			$ses->set('parent_cat', $parent_cat);
			$ses->set('cat_child', $cat_child);
			$ses->set('first_child', $cat_fchild);
			$ses->close();
		} else {
			return false;
		}
	}

	public static function find()
	{
		return new LettersQuery(get_called_class());
	}

	public static function getCategoryByAlias($alias)
	{
		self::$alias = $alias;
		return static::getDb()->cache(function () {
			return self::find()->select(self::$arrSelected)->where(['alias' => self::$alias])->asArray()->one();
		}, self::DEPENDENCY_TIME);
	}

	// получаем все корни
	public static function getAllRootsNodes()
	{
		return static::getDb()->cache(function () {
			return self::find()->select(self::$arrSelected)->roots()->asArray()->all();
		}, self::DEPENDENCY_TIME);
	}

	// получаем все ветви
	public static function getAllLeavesNodes()
	{
		return static::getDb()->cache(function () {
			return self::find()->leaves()->select(self::$arrSelected)->asArray()->all();
		}, self::DEPENDENCY_TIME);
	}

	// получаем ветви указанного узла по id
	public static function getLeavesNodesById($id)
	{
		$model = self::findOne(['id' => $id]);
		return $model->leaves()->select(self::$arrSelected)->asArray()->all();
	}

	// получаем ветви указанного узла по alias
	public static function getLeavesNodesByAlias($alias)
	{
		self::$alias = $alias;
		return static::getDb()->cache(function () {
			$model = self::findOne(['alias' => self::$alias]);
			return $model->leaves()->select(self::$arrSelected)->asArray()->all();
		}, self::DEPENDENCY_TIME);
	}


	// получаем всех детей
	public static function getAllChildrenNodes()
	{
		return static::getDb()->cache(function () {
			return self::find()->children()->select(self::$arrSelected)->asArray()->all();
		}, self::DEPENDENCY_TIME);
	}

	// получаем детей указанного узла по id
	public static function getChildrenNodesById($id)
	{
		$model = self::findOne(['id' => $id]);
		return $model->children()->select(self::$arrSelected)->asArray()->all();
	}

	// получаем детей указанного узла по alias
	public static function getChildrenNodesByAlias($alias)
	{
		self::$alias = $alias;
		return static::getDb()->cache(function () {
			$model = self::findOne(['alias' => self::$alias]);
			return $model->children()->select(self::$arrSelected)->asArray()->all();
		}, self::DEPENDENCY_TIME);
	}

	// получаем первых детей указанного узла по id
	public static function getFirstChildrenNodesById($id)
	{
		$model = self::findOne(['id' => $id]);
		return $model->children(1)->select(self::$arrSelected)->asArray()->all();
	}

	// получаем первых детей указанного узла по alias
	public static function getFirstChildrenNodesByAlias($alias)
	{
		self::$alias = $alias;
		return static::getDb()->cache(function () {
			$model = self::findOne(['alias' => self::$alias]);
			return $model->children(1)->select(self::$arrSelected)->asArray()->all();
		}, self::DEPENDENCY_TIME);
	}

	// получаем всех родителей указанного узла по id
	public static function getAllParentNodesById($id)
	{
		$model = self::findOne(['id' => $id]);
		return $model->parents()->select(self::$arrSelected)->asArray()->all();
	}

	// получаем всех родителей указанного узла по alias
	public static function getAllParentNodesByAlias($alias)
	{
		self::$alias = $alias;
		return static::getDb()->cache(function () {
			$model = self::findOne(['alias' => self::$alias]);
			return $model->parents()->select(self::$arrSelected)->asArray()->all();
		}, self::DEPENDENCY_TIME);
	}

	// получаем главного родителя указанного узла по id
	public static function getFirstParentNodesById($id)
	{
		$model = self::findOne(['id' => $id]);
		return $model->parents(1)->select(self::$arrSelected)->asArray()->all();
	}

	// получаем главного родителя указанного узла по alias
	public static function getFirstParentNodesByAlias($alias)
	{
		$model = self::findOne(['alias' => $alias]);
		return $model->parents(1)->select(self::$arrSelected)->asArray()->all();
	}

}
