<?php

namespace common\models\banners;

use common\behaviors\CacheInvalidateBehavior;
use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property string $name
 * @property string $key
 * @property integer $status
 * @property integer $stage
 * @property integer $col_size
 * @property integer $height
 * @property integer $width
 *
 * @property BannerItem[] $items
 */
class Banner extends \yii\db\ActiveRecord
{
	const STATUS_DRAFT = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_ONLY_STAFF = 2;

	const STAGE_VERTICAL = '0';
	const STAGE_HORIZONTAL = '1';

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%banner}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'cacheInvalidate' => [
				'class' => CacheInvalidateBehavior::className(),
				'cacheComponent' => 'frontendCache',
				'keys' => [
					function ($model) {
						return [
							self::className(),
							$model->key
						];
					}
				]
			]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['key'], 'required'],
			[['key'], 'unique'],
			[['status', 'stage', 'col_size', 'height', 'width'], 'integer'],
			[['key'], 'string', 'max' => 32],
			[['name'], 'string', 'max' => 255]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'key' => 'Ключ',
			'name' => 'Расположение баннера',
			'status' => 'Включен',
			'stage' => 'Положение блока',
			'col_size' => 'Размер колонки',
			'height' => 'Высота изображения',
			'width' => 'Длинна изображения',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getItems()
	{
		return $this->hasMany(BannerItem::className(), ['banner_key' => 'key']);
	}

	/**
	 * @return array
	 */
	public static function bannerStages()
	{
		return [
			self::STAGE_VERTICAL => 'Вертикальное',
			self::STAGE_HORIZONTAL => 'Горизонтальное',
		];
	}

	/**
	 * @return array
	 */
	public static function bannerStatuses()
	{
		return [
			self::STATUS_ACTIVE => 'Активно',
			self::STATUS_DRAFT => 'Выключено',
			self::STATUS_ONLY_STAFF => 'Видно только администратору ',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getBannerStatus($id)
	{
		$status = self::bannerStatuses();
		return $status[$id];
	}

	/**
	 * @return array
	 */
	public static function bannerColSize()
	{
		return [
			'1' => 'Размер 1',
			'2' => 'Размер 2',
			'3' => 'Размер 3',
			'4' => 'Размер 4',
			'5' => 'Размер 5',
			'6' => 'Размер 6',
			'7' => 'Размер 7',
			'8' => 'Размер 8',
			'9' => 'Размер 9',
			'10' => 'Размер 10',
			'11' => 'Размер 11',
			'12' => 'Размер 12',
		];
	}
}
