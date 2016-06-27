<?php

namespace common\models\banners;

use Yii;

/**
 * This is the model class for table "banner_adv".
 *
 * @property integer $id
 * @property integer $status
 * @property string $name
 * @property string $hit_price
 * @property string $click_price
 * @property string $day_price
 * @property integer $hit_status
 * @property integer $click_status
 * @property integer $day_status
 * @property integer $hit_size
 * @property integer $click_size
 * @property integer $day_size
 * @property string $description
 *
 * @property BannerItem[] $bannerItems
 */
class BannerAdv extends \yii\db\ActiveRecord
{
	const STATUS_DRAFT = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_ONLY_STAFF = 2;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'banner_adv';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['status', 'hit_status', 'click_status', 'day_status', 'hit_size', 'click_size', 'day_size'], 'integer'],
			[['click_price', 'day_price', 'hit_price'], 'number'],
			[['name'], 'string', 'max' => 100],
			[['description'], 'string', 'max' => 500],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'status' => 'Активная',
			'name' => 'Название рекламной компании',
			'hit_price' => 'Стоимость одного показа',
			'click_price' => 'Стоимость одного клика',
			'day_price' => 'Стоимость одного дня показа',
			'hit_status' => 'Считать по показам',
			'click_status' => 'Считать по кликам',
			'day_status' => 'Считать по дням',
			'hit_size' => 'Кол-во показов для одного счета',
			'click_size' => 'Кол-во кликов для одного счета',
			'day_size' => 'Кол-во дней для одного счета',
			'description' => 'Описание',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getBannerItems()
	{
		return $this->hasMany(BannerItem::className(), ['id_adv_company' => 'id'])->inverseOf('idAdvCompany');
	}

	/**
	 * @return array
	 */
	public static function advertStatuses()
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
	public static function getAdvertStatus($id)
	{
		$status = self::bannerStatuses();
		return $status[$id];
	}
}
