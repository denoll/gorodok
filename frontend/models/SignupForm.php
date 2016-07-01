<?php
namespace frontend\models;

use common\models\users\User;
use common\models\firm\Firm;
use yii\base\Model;
use Yii;
use yii\bootstrap\Html;

/**
 * Class SignupForm
 * @package frontend\models
 *
 * @property string $username
 * @property string $company_name
 * @property integer $company
 * @property string $email
 * @property string $password
 * @property string $tel
 *
 */
class SignupForm extends Model
{
	public $username;
	public $company_name;
	public $email;
	public $password;
	public $company;
	public $tel;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['username', 'required', 'message' => 'Заполните пожалуйста поле.'],
			[['username'], 'string', 'min' => 2, 'max' => 80],

			[['company_name'], 'string', 'min' => 2, 'max' => 80],
			[['company_name'], 'required', 'on' => 'is_company'],

			['company', 'integer'],

			['email', 'required'],
			['email', 'string', 'max' => 255],
			['email', 'filter', 'filter' => 'trim'],
			['email', 'email'],
			['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот email адрес уже используется.'],

			['password', 'required', 'message' => 'Введите пароль (мин. 6 символов)'],
			[['password'], 'string', 'min' => 6, 'message' => 'Пароль должен содержать не менее 6 символов.'],
			['password', 'filter', 'filter' => 'strip_tags'],

			//[['tel'], 'string', 'max' => 15],
			//[['tel'], 'match', 'pattern'=>'/^(\+7)\d{10,10}$/', 'message' => 'Номер мобильного телефона должен иметь вид "+79047771199".'],
			//['tel', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот телефонный номер уже используется.'],
		];
	}

	public function attributeLabels()
	{
		return [
			'password' => 'Пароль',
			'id' => 'ID',
			'username' => \common\models\users\User::isCompany() ? 'Имя контактного лица' : 'Ваше имя',
			'company_name' => 'Компания',
			'email' => 'Email',
			'tel' => 'Тел',
			'name' => 'Имя',
			'surname' => 'Фамилия',
			'patronym' => 'Отчество',
		];
	}

	/**
	 * @return User|null
	 */
	public function signup()
	{
		if ($this->validate()) {
			if ($this->company == 1) {
				$user = new User();
				$user->company = $this->company;
				$user->company_name = $this->company_name;
			} else {
				$user = new User();
				$user->company = $this->company;
			}
			$user->username = $this->username;
			$user->email = $this->email;
			$user->setPassword($this->password);
			$user->generateAuthKey();
			if ($user->save()) {
				if ($this->company == 1) {
					if(empty($this->company_name)){
						Yii::$app->session->setFlash('error', '
							<h3><strong style="color: red;">Внимание!!!</strong><br>Вы не внесли название компании.</h3>
							<p>Рекомендуем Вам заполнить актуальное <strong style="color: darkred">"Название компании"</strong> на этой странице.</p>
							<p class="small_text" style="color: #0000aa; font-style: italic;">Зарегистрированные на сайте компании без указания актуального названия будут удалятся.</p>
						');
					}
				}
				return $user;
			}
		}
		return null;
	}
}
