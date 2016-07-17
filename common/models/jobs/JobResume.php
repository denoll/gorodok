<?php

namespace common\models\jobs;

use Yii;
use \yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use common\models\users\User;

/**
 * This is the model class for table "job_resume".
 *
 * @property string $id
 * @property string $id_user
 * @property integer $top
 * @property integer $vip
 * @property string $title
 * @property string $description
 * @property string $salary
 * @property string $created_at
 * @property string $updated_at
 * @property string $m_keyword
 * @property string $m_description
 *
 * @property JobCatRez[] $jobCatRezs
 * @property User $idUser
 */
class JobResume extends ActiveRecord
{


	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					//ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
				'value' => new Expression('NOW()'),
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'job_resume';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['title', 'employment'], 'required'],
			[['id_user', 'top', 'vip', 'employment'], 'integer'],
			[['status'], 'boolean'],
			[['salary'], 'number'],
			[['created_at', 'updated_at', 'top_date', 'vip_date'], 'safe'],
			[['title'], 'string', 'max' => 125],
			[['description'], 'string', 'max' => 125],
			[['m_keyword', 'm_description'], 'string', 'max' => 255],
			[['description', 'm_keyword', 'm_description'], 'filter', 'filter' => 'strip_tags'],
			[['description', 'title'], \common\components\stopWords\StopWord::className()],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'id_user' => 'Id User',
			'top' => 'На верх',
			'vip' => 'VIP',
			'employment' => 'График работы',
			'title' => 'Должность (позиция)',
			'description' => 'Краткое описание',
			'salary' => 'Заработная плата',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата изменения',
			'm_keyword' => 'Ключевые слова',
			'm_description' => 'Мета описание',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getJobCatRezs()
	{
		return $this->hasMany(JobCatRez::className(), ['id_res' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getIdUser()
	{
		return $this->hasOne(User::className(), ['id' => 'id_user']);
	}
}
