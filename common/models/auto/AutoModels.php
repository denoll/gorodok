<?php

namespace common\models\auto;

use Yii;

/**
 * This is the model class for table "auto_models".
 *
 * @property integer $id
 * @property integer $status
 * @property string $name
 * @property integer $brand_id
 * @property integer $item_type
 * @property integer $version
 *
 * @property AutoItem[] $autoItems
 * @property AutoBrands $brand
 * @property AutoModify[] $autoModifies
 * @property AutoVersions[] $autoVersions
 */
class AutoModels extends \yii\db\ActiveRecord
{

	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 0;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'auto_models';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['name'], 'string'],
			[['brand_id', 'item_type', 'version', 'status'], 'integer'],
			[['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoBrands::className(), 'targetAttribute' => ['brand_id' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Модель',
			'status' => 'Статус',
			'brand_id' => 'Марка',
			'item_type' => 'Item Type',
			'version' => 'Version',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAutoItems()
	{
		return $this->hasMany(AutoItem::className(), ['id_model' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getBrand()
	{
		return $this->hasOne(AutoBrands::className(), ['id' => 'brand_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAutoModifies()
	{
		return $this->hasMany(AutoModify::className(), ['model_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAutoVersions()
	{
		return $this->hasMany(AutoVersions::className(), ['model_id' => 'id']);
	}

	/**
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getAllModels()
	{
		return self::find()->where(['status'=>self::STATUS_ACTIVE])->all();
	}

	/**
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getModelsForOneBrand($id_brand)
	{
		return self::find()->where(['status'=>self::STATUS_ACTIVE, 'brand_id' => $id_brand])->all();
	}

	/**
	 * @param $id
	 * @return array|null|\yii\db\ActiveRecord
	 */
	public static function getOneModel($id){
		$id = (int)$id;
		if($id){
			return self::find()->where(['id'=>$id, 'status'=>self::STATUS_ACTIVE])->one();
		}
	}
}
