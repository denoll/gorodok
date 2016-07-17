<?php

namespace common\models\firm;

use common\models\users\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use denoll\filekit\behaviors\UploadBehavior;

/**
 * This is the model class for table "firm".
 *
 * @property integer $id
 * @property integer $id_cat
 * @property integer $id_user
 * @property integer $status
 * @property integer $show_requisites
 * @property string $name
 * @property string $tel
 * @property string $email
 * @property string $site
 * @property string $logo
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $mk
 * @property string $md
 * @property string $address
 * @property string $lat
 * @property string $lon
 * @property FirmCat $cat
 * @property array $image
 */
class Firm extends \yii\db\ActiveRecord
{
	const STATUS_DISABLE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_VERIFICATION = 2;

	const HEIGHT = 250;
	const WIDTH = 250;

	public $files = array();
	public $image;

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
			'file' => [
				'class' => UploadBehavior::className(),
				'filesStorage' => 'firmStorage',
				'attribute' => 'image',
				'pathAttribute' => 'logo',
				'baseUrlAttribute' => 'base_url',
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'firm';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id_cat', 'name'], 'required'],
			[['id_cat', 'id_user', 'status', 'show_requisites'], 'integer'],
			[['description'], 'string'],
			[['created_at', 'updated_at', 'image'], 'safe'],
			[['name'], 'string', 'max' => 100],
			[['lat', 'lon'], 'string', 'max' => 100],
			[['base_url', 'logo'], 'string', 'max' => 255],
			[['tel', 'email', 'site', 'address', 'mk', 'md'], 'string', 'max' => 255],
			[['id_cat'], 'exist', 'skipOnError' => true, 'targetClass' => FirmCat::className(), 'targetAttribute' => ['id_cat' => 'id']],
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
			'id_cat' => 'Категория',
			'id_user' => 'Пользователь',
			'image' => 'Логотип',
			'status' => 'Статус',
			'show_requisites' => 'Показывать данные о компании в каталоге "Полезные адреса"',
			'name' => 'Название компании',
			'tel' => 'Телефон',
			'email' => 'Email',
			'site' => 'Сайт',
			'logo' => 'Логотип',
			'address' => 'Адрес',
			'lat' => 'Широта',
			'lon' => 'Долгота',
			'description' => 'Описание',
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
		return $this->hasOne(FirmCat::className(), ['id' => 'id_cat'])->inverseOf('firms');
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUsers()
	{
		return $this->hasOne(User::className(), ['id' => 'id_user'])->select(['id','username','status','company_name','company'])->andWhere(['company'=>1, 'status' => User::STATUS_ACTIVE]);
	}
}
