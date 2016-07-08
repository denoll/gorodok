<?php

namespace common\models\konkurs;

use Yii;
use common\models\users\User;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use denoll\filekit\behaviors\UploadBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "konkurs_item".
 *
 * @property integer $id
 * @property integer $id_konkurs
 * @property integer $id_user
 * @property string $base_url
 * @property string $img
 * @property string $image
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property integer $yes
 * @property integer $no
 * @property integer $scope
 *
 * @property Konkurs $konkurs
 * @property User $user
 * @property KonkursVote[] $votes
 */
class KonkursItem extends \yii\db\ActiveRecord
{

	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 0;
	const HEIGHT_IMG = 600;
	const WIDTH_IMG = 400;

	public $height;
	public $width;
	public $image;

	/**
	 * @return array
	 */
	public function behaviors()
	{
		return [
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
				'value' => new Expression('NOW()'),
			],
			'file' => [
				'class' => UploadBehavior::className(),
				'filesStorage' => 'konkursItemStorage',
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
		return 'konkurs_item';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id_konkurs', 'id_user', 'status', 'yes', 'no', 'scope', 'height', 'width'], 'integer'],
			[['created_at', 'updated_at', 'image'], 'safe'],
			[['base_url', 'img', 'description'], 'string', 'max' => 255],
			[['id_konkurs'], 'exist', 'skipOnError' => true, 'targetClass' => Konkurs::className(), 'targetAttribute' => ['id_konkurs' => 'id']],
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
			'id_konkurs' => 'Конкурс',
			'id_user' => 'Пользователь',
			'base_url' => 'Base Url',
			'img' => 'Фото',
			'image' => 'Фото',
			'description' => 'Текст',
			'created_at' => 'Создан',
			'updated_at' => 'Изменен',
			'status' => 'Статус',
			'yes' => 'За',
			'no' => 'Против',
			'scope' => 'Баллы',
		];
	}

	public static function allKonkurs($period = false){
		if($period){
			return Konkurs::find()
				->where(['status'=>Konkurs::STATUS_ACTIVE])
				->andWhere(['<','start',date('Y-m-d H:i:s')])
				->andWhere(['>','stop',date('Y-m-d H:i:s')])
				->asArray()->all();
		}else{
			return Konkurs::find()->where(['status'=>Konkurs::STATUS_ACTIVE])->asArray()->all();
		}
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getKonkurs()
	{
		return $this->hasOne(Konkurs::className(), ['id' => 'id_konkurs']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'id_user']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getVotes()
	{
		return $this->hasMany(KonkursVote::className(), ['id_item' => 'id']);
	}
}
