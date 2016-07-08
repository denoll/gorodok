<?php

namespace common\models\konkurs;

use Yii;
use common\models\users\User;

/**
 * This is the model class for table "konkurs_voite".
 *
 * @property integer $id_konkurs
 * @property integer $id_item
 * @property integer $id_user
 * @property integer $yes
 * @property integer $no
 * @property integer $scope
 * @property string $date
 *
 * @property User $user
 * @property Konkurs $konkurs
 * @property KonkursItem $item
 */
class KonkursVote extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'konkurs_vote';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id_konkurs', 'id_item', 'id_user'], 'required'],
			[['id_konkurs', 'id_item', 'id_user', 'yes', 'no', 'scope'], 'integer'],
			[['date'], 'safe'],
			[['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
			[['id_konkurs'], 'exist', 'skipOnError' => true, 'targetClass' => Konkurs::className(), 'targetAttribute' => ['id_konkurs' => 'id']],
			[['id_item'], 'exist', 'skipOnError' => true, 'targetClass' => KonkursItem::className(), 'targetAttribute' => ['id_item' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id_konkurs' => 'Конкурс',
			'id_item' => 'Элемент',
			'id_user' => 'Пользователь',
			'yes' => 'За',
			'no' => 'Против',
			'scope' => 'Балл',
			'date' => 'Дата голосования',
		];
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
	public function getKonkurs()
	{
		return $this->hasOne(Konkurs::className(), ['id' => 'id_konkurs']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getItem()
	{
		return $this->hasOne(KonkursItem::className(), ['id' => 'id_item']);
	}
}
