<?php

namespace common\models\konkurs;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "konkurs_cat".
 *
 * @property integer $id
 * @property integer $id_parent
 * @property integer $status
 * @property integer $order
 * @property string $name
 * @property string $slug
 * @property string $mk
 * @property string $md
 *
 * @property Konkurs[] $konkurss
 * @property KonkursCat $idParent
 * @property KonkursCat[] $konkursCats
 */
class KonkursCat extends \yii\db\ActiveRecord
{

	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 0;

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'name',
				'slugAttribute' => 'slug',
				'immutable' => true,
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'konkurs_cat';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id_parent', 'status', 'order'], 'integer'],
			[['name'], 'string', 'max' => 150],
			[['slug', 'mk', 'md'], 'string', 'max' => 255],
			[['id_parent'], 'exist', 'skipOnError' => true, 'targetClass' => KonkursCat::className(), 'targetAttribute' => ['id_parent' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'id_parent' => 'Родительская категория',
			'status' => 'Status',
			'order' => 'Порядок',
			'name' => 'Категория',
			'slug' => 'Алиас',
			'mk' => 'Ключевые слова',
			'md' => 'Мета описание',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getKonkurss()
	{
		return $this->hasMany(Konkurs::className(), ['id_cat' => 'id'])->inverseOf('idCat');
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getParent()
	{
		return $this->hasOne(KonkursCat::className(), ['id' => 'id_parent'])->inverseOf('konkursCats');
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getKonkursCats()
	{
		return $this->hasMany(KonkursCat::className(), ['id_parent' => 'id'])->inverseOf('idParent');
	}
}
