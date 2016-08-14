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
 * @property string $name
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
 * @property integer $sum
 * @property integer $vote_count
 *
 * @property Konkurs $konkurs
 * @property User $user
 * @property KonkursVote[] $votes
 */
class KonkursItem extends \yii\db\ActiveRecord
{

	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 0;
	const STATUS_VERIFICATION = 2;

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
			['name', 'required'],
			[['id_konkurs', 'id_user', 'status', 'yes', 'no', 'height', 'width', 'vote_count'], 'integer'],
			[['scope', 'sum'], 'number'],
			[['created_at', 'updated_at', 'image'], 'safe'],
			[['base_url', 'img'], 'string', 'max' => 255],
			[['name'], 'string', 'max' => 32],
			[['description'], 'string', 'max' => 2000],
			[['description', 'name'], 'filter', 'filter' => 'strip_tags'],
			[['id_konkurs'], 'exist', 'skipOnError' => true, 'targetClass' => Konkurs::className(), 'targetAttribute' => ['id_konkurs' => 'id']],
			[['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
			[['description', 'name'], \common\components\stopWords\StopWord::className()],
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
			'name' => 'Название',
			'base_url' => 'Base Url',
			'img' => 'Фото',
			'image' => 'Фото',
			'description' => 'Текст',
			'created_at' => 'Создан',
			'updated_at' => 'Изменен',
			'status' => 'Статус',
			'yes' => 'За',
			'no' => 'Против',
			'scope' => 'Средний балл',
			'sum' => 'Сумма баллов',
			'vote_count' => 'Проголосовало (чел)',
		];
	}

	/**
	 * @param int $id_item KonkursItem id
	 * @return float
	 */
	public static function getSumScope($id_item){
		$vote = KonkursVote::find()->select('SUM(scope) AS scope, COUNT(id_user) AS count')->where(['id_item'=>$id_item])->asArray()->one();
		if($vote['scope'] !== null && $vote['count'] !== null){
			$model = self::findOne($id_item);
			$model->vote_count = $vote['count'];
			$model->scope = $vote['scope'] !== 0 ? $vote['scope'] / $vote['count'] : 0;
			$model->sum = $vote['scope'] !== 0 ? $vote['scope'] : 0;
			$model->save();
		}

	}

	/**
	 * @param $id_konkurs
	 * @return bool
	 */
	public static function verificationsUserItems($id_konkurs){
		if(Yii::$app->user->isGuest) return false;
		$user = Yii::$app->user->getIdentity();
		$items = self::find()->where(['id_user'=>$user->id, 'id_konkurs'=>$id_konkurs])->andWhere(['<>', 'status', self::STATUS_DISABLE])->all();
		if($items){
			return true;
		}else return false;
	}

	/**
	 * @param bool $period
	 * @return array|\yii\db\ActiveRecord[]
	 */
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
	public function getKonkursWithCat()
	{
		return $this->hasOne(Konkurs::className(), ['id' => 'id_konkurs'])->with('cat');
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
	public function getVote()
	{
		if(Yii::$app->user->isGuest) return $this->hasOne(KonkursVote::className(), ['id_item' => 'id'])->andWhere(['id_user' => 0])->asArray();
		return $this->hasOne(KonkursVote::className(), ['id_item' => 'id'])->andWhere(['id_user' => Yii::$app->user->id])->asArray();
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getVotes()
	{
		return $this->hasMany(KonkursVote::className(), ['id_item' => 'id']);
	}

	/**
	 * @return array
	 */
	public static function getStatuses()
	{
		return [
			self::STATUS_ACTIVE => 'Опубликован',
			self::STATUS_DISABLE => 'Снят с публикации',
			self::STATUS_VERIFICATION => 'На проверке'
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getCurStatus($id)
	{
		$statuses = self::getStatuses();
		return $statuses[$id];
	}
}
