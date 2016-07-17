<?php

namespace common\models;

use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "news_cat".
 *
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $lvl
 * @property string $name
 * @property string $url
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
 * @property News[] $news
 */
class MainMenu extends \kartik\tree\models\Tree
{
	const DURATION = 2592000;
	private static $arrSelected = ['root', 'lvl', 'lft', 'rgt', 'id', 'name', 'cat', 'url', 'var', 'active', 'm_k', 'm_d'];

	public $_extensions;
	public $_items;
	public static $settings = ['root' => 35, 'lvl' => 1, 'includeLanguage' => true];
	public static $menu_item;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		$rules = parent::rules();
		$rules[] = [['m_k', 'm_d', 'url', 'cat'], 'string', 'max' => 255];
		$rules[] = [['var'], 'string', 'max' => 50];
		$rules[] = [['_extensions', '_items'], 'safe'];
		return $rules;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		parent::attributeLabels();
		return [
			'id' => 'ID',
			'active' => 'Активная',
			'name' => 'Название',
			'var' => 'HTML переменная',
			'cat' => 'Категория',
			'_extensions' => 'Расширения',
			'_items' => 'Елементы',
			'url' => 'Url',
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'main_menu';
	}

	/**
	 * @inheritdoc
	 */
	public function isDisabled()
	{

	}

	public static function getMenuTree()
	{
		$items = [];
		// Load categories
		//$menu_items = self::find()->where(['root' => $rootItem->id, 'lvl' => $settings['lvl']])->addOrderBy('lft')->all();
		$menu_items = self::getDb()->cache(function ($db) {
			$rootItem = self::findOne(self::$settings['root']);
			return self::find()->where(['root' => $rootItem->id, 'lvl' => self::$settings['lvl']])->addOrderBy('lft')->all();
		}, self::DURATION);

		foreach ($menu_items as $k => $menu_item) {
			$item = [
				'label' => $menu_item->name,
				'cat' => $menu_item->cat,
				'url' => $menu_item->url,
				'var' => $menu_item->var,
				'active' => Yii::$app->request->url == $menu_item->url ? true : false,
				'visible' => $menu_item->visible,
			];

			// Get the item's children
			self::$menu_item = $menu_item;
			$children = self::getDb()->cache(function ($db) {
				return self::$menu_item->children(1)->all();
			}, self::DURATION);

			if ($children) {
				$item['items'] = [];

				foreach ($children as $k => $child) {

					$item['items'][] = [
						'label' => $child->name,
						'cat' => $child->cat,
						'url' => $child->url,
						'var' => $child->var,
						'active' => Yii::$app->request->url == $child->url ? true : false,
						'visible' => $child->visible,
					];
					self::$menu_item = $child;
					$tr_lvl = self::getDb()->cache(function ($db) {
						return self::$menu_item->children()->all();
					}, self::DURATION);
					if ($tr_lvl) {
						foreach ($tr_lvl as $t => $tr) {
							$item['items'][$k]['items'][] = [
								'label' => $tr->name,
								'cat' => $tr->cat,
								'url' => $tr->url,
								'var' => $tr->var,
								'active' => Yii::$app->request->url == $tr->url ? true : false,
								'visible' => $tr->visible,
							];
						}
					}
				}
			}

			// Add new item to items array
			$items[] = $item;
		}

		$user = [
			['label' => Yii::t('frontend', 'Signup'), 'url' => '/user/sign-in/signup', 'visible' => Yii::$app->user->isGuest],
			['label' => Yii::t('frontend', 'Login'), 'url' => '/user/sign-in/login', 'visible' => Yii::$app->user->isGuest],
			[
				'label' => Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->getPublicIdentity(),
				'visible' => !Yii::$app->user->isGuest,
				'items' => [
					[
						'label' => Yii::t('frontend', 'Settings'),
						'url' => '/user/default/index',
						'visible' => !Yii::$app->user->isGuest,
					],

					[
						'label' => Yii::t('frontend', 'Logout'),
						'url' => '/user/sign-in/logout',
						'visible' => !Yii::$app->user->isGuest,
						'linkOptions' => ['data-method' => 'post']
					]
				]
			]
		];

		$items = ArrayHelper::merge($items, $user);

		return $items;
	}

	// получаем детей указанного узла по cat
	public static function getChildrenNodesBySlug($cat)
	{
		$model = self::findOne(['cat' => $cat]);
		return $model->children()->select(self::$arrSelected)->andWhere(['active' => 1]);
	}

	public static function getExtension($id)
	{
		return Extensions::find()->where(['status' => 1, 'id' => $id])->asArray()->one();
	}

	public static function getExtensions()
	{
		return Extensions::find()->where(['status' => 1])->asArray()->all();
	}
}
