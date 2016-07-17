<?php

namespace common\models\letters;

use Yii;
use common\models\users\User;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "letters_comments".
 *
 * @property string $id
 * @property string $parent
 * @property string $id_user
 * @property string $id_letter
 * @property integer $status
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Letters $idLetter
 * @property User $idUser
 */
class LettersComments extends ActiveRecord
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
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
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
		return 'letters_comments';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['parent', 'id_user', 'id_letter', 'status'], 'integer'],
			[['text'], 'string'],
			[['text'], 'filter', 'filter' => 'strip_tags'],
			[['created_at', 'updated_at'], 'safe'],
			[['id_letter'], 'exist', 'skipOnError' => true, 'targetClass' => Letters::className(), 'targetAttribute' => ['id_letter' => 'id']],
			[['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
			[['text'], \common\components\stopWords\StopWord::className()],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'parent' => 'Parent',
			'id_user' => 'Пользователь',
			'id_letter' => 'Письмо',
			'status' => 'Статус',
			'text' => 'Комментарий',
			'created_at' => 'Создан',
			'updated_at' => 'Изменен',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getLetter()
	{
		return $this->hasOne(Letters::className(), ['id' => 'id_letter']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'id_user']);
	}
}
