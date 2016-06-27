<?php

namespace common\models\realty;

use Yii;
use common\models\users\User;

/**
 * This is the model class for table "realty_rent_img".
 *
 * @property integer $id
 * @property integer $id_ads
 * @property integer $id_user
 * @property integer $order
 * @property string $img
 * @property string $base_url
 * @property string $type
 * @property string $name
 * @property string $size
 *
 * @property RealtyRent $idAds
 * @property User $idUser
 */
class RealtyRentImg extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'realty_rent_img';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id_ads', 'id_user', 'order'], 'integer'],
			[['type', 'name', 'size'], 'string', 'max' => 50],
			[['img', 'base_url'], 'string', 'max' => 255],
			[['id_ads'], 'exist', 'skipOnError' => true, 'targetClass' => RealtyRent::className(), 'targetAttribute' => ['id_ads' => 'id']],
			[['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'id_ads' => 'Id Ads',
			'id_user' => 'Id User',
			'img' => 'Img',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAds()
	{
		return $this->hasOne(RealtyRent::className(), ['id' => 'id_ads']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'id_user']);
	}
}
