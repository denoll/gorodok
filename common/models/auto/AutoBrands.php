<?php

namespace common\models\auto;

use Yii;

/**
 * This is the model class for table "auto_brands".
 *
 * @property integer $id
 * @property string $name
 * @property integer $item_type
 * @property integer $version
 *
 * @property AutoItem[] $autoItems
 * @property AutoModels[] $autoModels
 */
class AutoBrands extends \yii\db\ActiveRecord
{

	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 0;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'auto_brands';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['name'], 'string'],
			[['item_type', 'version', 'status'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Бренд',
			'status' => 'Статус',
			'item_type' => 'Item Type',
			'version' => 'Version',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAutoItems()
	{
		return $this->hasMany(AutoItem::className(), ['id_brand' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAutoModels()
	{
		return $this->hasMany(AutoModels::className(), ['brand_id' => 'id']);
	}

	/**
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getAllBrands()
	{
		return self::find()->where(['status' => self::STATUS_ACTIVE])->all();
	}

	/**
	 * @param $id
	 * @return array|null|\yii\db\ActiveRecord
	 */
	public static function getOneBrand($id)
	{
		$id = (int)$id;
		if ($id) {
			return  self::find()->where(['id' => $id, 'status' => self::STATUS_ACTIVE])->one();
		}
	}
}
