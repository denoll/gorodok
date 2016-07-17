<?php

namespace common\models\auto;

use Yii;

/**
 * This is the model class for table "auto_img".
 *
 * @property integer $id
 * @property integer $id_item
 * @property integer $order
 * @property string $base_url
 * @property string $path
 * @property string $name
 * @property string $size
 * @property string $type
 * @property string $created_at
 *
 * @property AutoItem $item
 */
class AutoImg extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'auto_img';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id_item', 'order'], 'integer'],
			[['created_at'], 'safe'],
			[['base_url', 'name', 'size', 'type'], 'string', 'max' => 255],
			[['path'], 'string', 'max' => 1024],
			[['id_item'], 'exist', 'skipOnError' => true, 'targetClass' => AutoItem::className(), 'targetAttribute' => ['id_item' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'id_item' => 'Id Item',
			'base_url' => 'Base Url',
			'path' => 'Img',
			'name' => 'Name',
			'size' => 'Size',
			'created_at' => 'Created At',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getItem()
	{
		return $this->hasOne(AutoItem::className(), ['id' => 'id_item']);
	}
}
