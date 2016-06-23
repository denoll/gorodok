<?php

namespace common\models\users;

use common\models\jobs\JobProfile;
use common\models\jobs\JobResume;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $company_name
 * @property integer $company
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property string $patronym
 * @property integer $confirmed_at
 * @property integer $blocked_at
 * @property string $status
 * @property string $created_at
 * @property integer $updated_at
 * @property integer $rating
 * @property integer $flags
 * @property string $lat
 * @property string $long
 * @property string $ip
 * @property string $avatar
 * @property integer $count_fm
 * @property integer $count_ft
 * @property string $auth_key
 * @property string $password_hash
 * @property integer $account
 * @property integer $sum_in
 * @property integer $sum_out
 * @property SocialAccount[] $socialAccounts
 * @property Token[] $tokens
 */
class User extends ActiveRecord implements IdentityInterface //ActiveRecord implements IdentityInterface
{
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 10;
	const ROLE_ADMIN = 'admin';

	public $old_password;
	public $password;
	public $image;
	public $crop_info;


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'user';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['username','email'], 'required'],

			[['email', 'tel'], 'unique'],

			['email', 'email', 'message' => 'Это не похоже на e-mail адрес.'],

			[['status', 'rating', 'count_fm', 'count_ft', 'company', 'doctor'], 'integer'],
			[['account', 'sum_in', 'sum_out'], 'number'],

			[['crop_info', 'updated_at', 'created_at'], 'safe'],

			[['name', 'surname', 'patronym', 'avatar'], 'string', 'min' => 2, 'max' => 50],
			[['auth_key'], 'string', 'max' => 32],
			[['country', 'region', 'city', 'password_hash', 'password_reset_token'], 'string', 'max' => 60],

			[['password'], 'string', 'min' => 6, 'message' => 'Пароль должен содержать не менее 6 символов.'],

			[['username'], 'string', 'min' => 2, 'max' => 80],
			[['username','name','surname','patronym','password'], 'filter', 'filter' => 'trim'],
			[['username', 'name', 'surname', 'patronym','password','old_password'], 'filter', 'filter' => 'strip_tags'],

			[['company_name'], 'string', 'min' => 2, 'max' => 80],
			[['company_name'], 'filter', 'filter' => 'trim'],
			[['company_name'], 'filter', 'filter' => 'strip_tags'],
			[['company_name'], 'required', 'on' => 'is_company'],

			[['tel'], 'match', 'pattern'=>'/^(\+7)\d{10,10}$/', 'message' => 'Номер мобильного телефона должен иметь вид "+79047771199".'],

			[
				['image'],
				'image',
				'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
				'mimeTypes' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'],
				'maxSize' => 1024 * 150,
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'password' => 'Пароль',
			'old_password' => 'Старый пароль',
			'id' => 'ID',
			'username' => 'Ваше имя',
			'company_name' => 'Компания',
			'email' => 'Email',
			'tel' => 'Тел',
			'name' => 'Имя',
			'surname' => 'Фамилия',
			'patronym' => 'Отчество',
			'account' => 'Баланс',
			'sum_in' => 'Сумма пополнений',
			'sum_out' => 'Сумма расходов',
			'confirmed_at' => 'Дата подтверждения',
			'blocked_at' => 'Дата блокировки',
			'status' => 'Статус',
			'company' => 'Как организация',
			'doctor' => 'Вы доктор',
			'created_at' => 'Дата регистрации',
			'updated_at' => 'Дата изменения',
			'rating' => 'Рейтинг',
			'flags' => 'Флаг',
			'country' => 'Страна',
			'region' => 'Регион',
			'city' => 'Нас. пункт (город или др.)',
			'lat' => 'Широта',
			'long' => 'Долгота',
			'ip' => 'IP адрес',
			'avatar' => 'Аватар',
			'count_fm' => 'Написал сообщений на форуме',
			'count_ft' => 'Создал тем на форуме',
			'auth_key' => 'Auth Key',
			'password_hash' => 'Password Hash',
		];
	}

	public static function isAdmin()
	{
		if (!Yii::$app->user->isGuest) {
			$user = Yii::$app->user->getIdentity();
			$admin = \Yii::$app->authManager->getAssignment(self::ROLE_ADMIN, $user->getId());
			return $admin; // возвращает false или true
		} else {
			return false;
		}
	}

	public static function isCompany()
	{
		$user = Yii::$app->user->getIdentity();
		if ($user->company == 1) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Payments update function for one user
	 * @param User $user_id
	 * @return bool
	 */
	public static function paymentsSumUpdate($user_id){
		$user = self::findOne($user_id);
		$summ = UserAccount::find()->select('SUM(pay_in) as sum_in, SUM(pay_out) as sum_out')->where(['id_user'=>$user_id])->asArray()->one();
		$user->sum_in = $summ['sum_in'] === null ? 0 : $summ['sum_in'];
		$user->sum_out = $summ['sum_out'] === null ? 0 : $summ['sum_out'];
		$user->account = $user->sum_in - $user->sum_out;
		if($user->save()){
			return true;
		}else{
			return false;
		}
	}
	
	

	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}

	public function setNewPassword($new_password)
	{
		try {
			$this->password_hash = Yii::$app->security->generatePasswordHash($new_password);
			return true;
		} catch (InvalidParamException $e) {
			print_r($e);
			return false;
		}
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString();
	}

	/**
	 * @inheritdoc
	 * @return UserQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new UserQuery(get_called_class());
	}

	public function getAuth()
	{
		return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
	}

	public function getEdu()
	{
		return $this->hasMany(UserEdu::className(), ['id_user' => 'id']);
	}

	public function getExp()
	{
		return $this->hasMany(UserExp::className(), ['id_user' => 'id']);
	}

	public function getResume()
	{
		return $this->hasMany(JobResume::className(), ['id_user' => 'id']);
	}

	public function getProfile()
	{
		return $this->hasOne(JobProfile::className(), ['id_user' => 'id']);
	}

	public function getCompany()
	{
		return $this->hasOne(Company::className(), ['id_user' => 'id']);
	}

	public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id)
	{
		return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by username
	 *
	 * @param string $email
	 * @return static|null
	 */
	public static function findByEmail($email)
	{
		return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token)
	{
		if (!static::isPasswordResetTokenValid($token)) {
			return null;
		}

		return static::findOne([
			'password_reset_token' => $token,
			'status' => self::STATUS_ACTIVE,
		]);
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 * @return boolean
	 */
	public static function isPasswordResetTokenValid($token)
	{
		if (empty($token)) {
			return false;
		}

		$timestamp = (int)substr($token, strrpos($token, '_') + 1);
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];
		return $timestamp + $expire >= time();
	}

	/**
	 * @inheritdoc
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken()
	{
		$this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken()
	{
		$this->password_reset_token = null;
	}

}
