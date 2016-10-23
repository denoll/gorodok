<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "api".
 *
 * @property string $key
 * @property string $value
 */
class Api extends \yii\db\ActiveRecord
{
	public static $duration = 3600;
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'api';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[ [ 'key' ], 'string', 'max' => 128 ],
			[ [ 'value' ], 'string', 'max' => 255 ],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'key'   => 'Ключ',
			'value' => 'Значение',
		];
	}

	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public static function getLat(){
		$result = self::getDb()->cache(function ($db){
			$data = self::findOne(['key'=>'lat']);
			return $data->value;
		}, self::$duration);
		return $result;
	}

	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public static function getLon(){
		$result = self::getDb()->cache(function ($db){
			$data = self::findOne(['key'=>'lon']);
			return $data->value;
		}, self::$duration);
		return $result;
	}
}
