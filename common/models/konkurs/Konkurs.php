<?php

namespace common\models\konkurs;

use common\models\users\User;
use Yii;
use \yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use denoll\filekit\behaviors\UploadBehavior;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "konkurs".
 *
 * @property integer $id
 * @property integer $id_cat
 * @property string $name
 * @property string $slug
 * @property integer $status
 * @property integer $show_img
 * @property integer $show_des
 * @property integer $stars
 * @property string $title
 * @property string $description
 * @property string $base_url
 * @property string $img
 * @property integer $width
 * @property integer $height
 * @property string $start
 * @property string $stop
 * @property string $created_at
 * @property string $updated_at
 * @property string $mk
 * @property string $md
 *
 * @property KonkursCat[] $cat
 * @property KonkursItem[] $items
 * @property KonkursVote[] $votes
 */
class Konkurs extends ActiveRecord
{

	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 0;
	const HEIGHT_IMG = 250;
	const WIDTH_IMG = 250;

	public $image;


	/**
	 * @return array
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
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at', 'start'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
				'value' => new Expression('NOW()'),
			],
			'file' => [
				'class' => UploadBehavior::className(),
				'filesStorage' => 'konkursStorage',
				'attribute' => 'image',
				'pathAttribute' => 'img',
				'baseUrlAttribute' => 'base_url',
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'konkurs';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['id', 'id_cat', 'status', 'show_img', 'show_des', 'stars', 'width', 'height'], 'integer'],
			[['description'], 'string'],
			[['image', 'start', 'stop', 'created_at', 'updated_at'], 'safe'],
			[['name', 'slug', 'title', 'base_url', 'img', 'mk', 'md'], 'string', 'max' => 255],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Название',
			'id_cat' => 'Категория',
			'slug' => 'Алиас',
			'status' => 'Статус',
			'show_img' => 'Конкурс изображений',
			'show_des' => 'Текстовый конкурс',
			'stars' => 'Тип конкурса', // 'По очкам или За/Против',
			'title' => 'Заголовок',
			'description' => 'Описание',
			'image' => 'Картинка',
			'img' => 'Картинка',
			'width' => 'Длинна изображения',
			'height' => 'Высота изображения',
			'start' => 'Старт конкурса',
			'stop' => 'Окончание конкурса',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата изменения',
			'mk' => 'Ключевые слова',
			'md' => 'Мета описание',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCat()
	{
		return $this->hasOne(KonkursCat::className(), ['id' => 'id_cat']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getItems()
	{
		return $this->hasMany(KonkursItem::className(), ['id_konkurs' => 'id'])->andWhere(['status'=>KonkursItem::STATUS_ACTIVE]);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getVotes()
	{
		return $this->hasMany(KonkursVote::className(), ['id_konkurs' => 'id']);
	}
}
