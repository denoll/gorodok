<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metatags".
 *
 * @property string $key
 * @property string $url
 * @property string $title
 * @property string $kw
 * @property string $desc
 * @property string $info
 */
class Metatags extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'metatags';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[ [ 'key', 'url' ], 'required' ],
			[ [ 'key' ], 'string', 'max' => 128 ],
			[ [ 'url' ], 'string', 'max' => 512 ],
			[ [ 'title', 'kw', 'desc', 'info' ], 'string', 'max' => 255 ],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'key'   => 'Ключ страницы',
			'url'   => 'Url страницы',
			'title' => 'Заголовок',
			'kw'    => 'Ключевые слова',
			'desc'  => 'Мета описание',
			'info'  => 'Информация',
		];
	}
}
