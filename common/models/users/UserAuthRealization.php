<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 01.06.2016
 * Time: 16:08
 */

namespace common\models\users;

use common\models\CommonQuery;
use Yii;
use yii\authclient\AuthAction;
use yii\bootstrap\Html;

class UserAuthRealization extends User
{

	/**
	 * @param object $attributes
	 * @param Auth $auth_model
	 * @param string $password
	 */
	public $attributes;
	public $auth_model;

	private $auto_password;


	public function setUserAttributes($client)
	{
		if (!empty($client)) {
			$attributes = $client->getUserAttributes();
			/*echo '<pre>';
			print_r($attributes);
			echo '</pre>';
			die;*/
			switch ($client->getName()){
				case 'facebook' :
					$this->attributes = [
						'id' => $attributes['id'],
						'username' => ($attributes['first_name'] || $attributes['last_name']) ? implode(' ', [$attributes['first_name'], $attributes['last_name']]) : $attributes['email'],
						'email' => $attributes['email'],
					]; break;
				case 'google':
					$this->attributes = [
						'id' => $attributes['id'],
						'username' => !empty($attributes['displayName']) ? $attributes['displayName'] : $attributes['emails'][0]['value'],
						'email' => $attributes['emails'][0]['value'],
					]; break;
				case 'yandex':
					$this->attributes = [
						'id' => $attributes['id'],
						'username' => $attributes['real_name'] ? $attributes['real_name'] : ($attributes['first_name'] || $attributes['last_name']) ? implode(' ', [$attributes['first_name'], $attributes['last_name']]) : $attributes['default_email'],
						'email' => $attributes['email'] ? $attributes['email'] : $attributes['default_email'] ? $attributes['default_email'] : $attributes['emails'][0],
					]; break;
				case 'vkontakte':
					$this->attributes = [
						'id' => $attributes['id'],
						'username' => ($attributes['first_name'] && $attributes['last_name']) ? implode(' ', [$attributes['first_name'], $attributes['last_name']]) : $attributes['email'],
						'email' => $attributes['email'],
					]; break;
				case 'odnoklassniki':
					$this->attributes = [
						'id' => $attributes['id'],
						'username' => $attributes['name'],
						'email' => $attributes['email'],
					]; break;
				case 'mailru':
					$this->attributes = $attributes;/* [
						'id' => $attributes['id'],
						'username' => ($attributes['first_name'] && $attributes['last_name']) ? implode(' ', [$attributes['first_name'], $attributes['last_name']]) : $attributes['email'],
						'email' => $attributes['email'],
					];*/ break;
			}

		}
	}
	/**
	 * Авторизация OAuth с помощью внешних сервисов Yandex, Google, Facebook, VKontakte, Mail.ru, Odnoklassniki
	 * @param object $client
	 */
	public function oAuthorization($client)
	{
		if (!empty($client)) {
			$this->setUserAttributes($client);
			//echo '<pre> '.$client->getName().' <br>';
			//print_r($this->attributes); exit;
			//echo '</pre>';
		} else {
			$this->attributes = null;
		}

		if ($this->attributes) {
			$this->auth_model = $this->getAuthService($client);
		}

		if (Yii::$app->user->isGuest) {
			if ($this->auth_model) { //Если есть уже аакаунт то авторизация
				$user = $this->auth_model->user;
				Yii::$app->user->login($user);
			} else { // регистрация

				if (!empty($this->attributes['email']) && User::find()->where(['email' => $this->attributes['email']])->exists()) {
					if (!$this->auth_model) { // добавляем внешний сервис аутентификации
						$user = User::find()->where(['email' => $this->attributes['email']])->one();
						$this->setNewAuthService($client, $user);

						$this->auth_model = $this->getAuthService($client);

						if ($this->auth_model) { // авторизация
							$user = $this->auth_model->user;
							Yii::$app->user->login($user);
						}
					}
					Yii::$app->getSession()->setFlash('info', [
						'Вы успешно авторизавны на сайте, через сервис '.$client->getTitle(),
					]);
				} else {
					// Тут нужно реализовать проверку все ли поля заполнены для того что бы создать нового пользователя
					//Создаем нового пользователя
					if(!empty($this->attributes['email']) && !empty($this->attributes['username'])){ //Если email & username пришли из внешнего сервиса то создаем новый аккаунт
						$new_user = $this->createUserFromOAuth($this->attributes, $client);
						if (Yii::$app->user->login($new_user)) {
							Yii::$app->getSession()->setFlash('info', [
								'<h3>Вы успешно зарегистрированы на сайте.<br>Ваши регистрационные данные отправлены Вам на email.</h3>
								<p>Для более полной информации, рекомендуем Вам указать еще свой телефон, '.Html::a('в своем профиле','/profile/default/index',['class'=>'btn btn-sm btn-info']).'</p>
								',
							]);
							//Отправляем Email пользователю с регистрационными данными
							CommonQuery::sendCreateUserEmail(Yii::$app->user->identity, $this->auto_password);
						} else {
							Yii::$app->getSession()->setFlash('error', [
								'Авторизация п каким-то причинам не удалась',
							]);
						}
					}else{
						Yii::$app->getSession()->setFlash('error', [
							'<h2>К сожалению регистрация через <strong>'.$client->title.'</strong> не удалась. </h2>
							<p>Скорее всего у Вас не указан <strong>Email</strong> в этом сервисе, или Вы запретили к нему доступ.</p>
							<p>Попробуйте авторизоваться через другие сервисы, либо пройдите стандартную регистрацию на сайте.</p>
							',
						]);
					}
				}
			}
		} else {
			if (!$this->auth_model) { // добавляем внешний сервис аутентификации
				$this->setNewAuthService($client);
			}
		}
	}

	/**
	 * Создание нового пользователя на основе пришедших внешних данных
	 * @param array $attributes
	 * @param $client
	 * @return User|null
	 * @throws \yii\db\Exception
	 */
	public function createUserFromOAuth(Array $attributes, $client)
	{
		$this->auto_password = Yii::$app->security->generateRandomString(6);

		$user = new User([
			'username' => $this->attributes['username'],
			'email' => $this->attributes['email'],
			'password' => $this->auto_password,
		]);
		$user->generateAuthKey();
		$user->generatePasswordResetToken();

		echo '<br>';
		print_r($attributes);// exit;
		echo '<br>';

		$transaction = $user->getDb()->beginTransaction();
		if ($user->save()) {
			$auth = new Auth([
				'user_id' => $user->id,
				'source' => $client->getId(),
				'source_id' => (string)$attributes['id'],
			]);
			if ($auth->save()) {
				$transaction->commit();
				// Send email to user with registration data
				return $user;
			} else {
				echo '1<br>';
				print_r($auth->getErrors());
				exit;
				return null;
			}
		} else {
			echo '2<br>';
			print_r($user->getErrors());
			exit;
			return null;
		}
		return null;
	}

	/**
	 * Получаем из таблицы Auth данные о пользовательском OAuth по пришедшему ID из внешнего сервиса
	 * @param $client
	 * @return array|null|\yii\db\ActiveRecord ['id','user_id','source','source_id','user']
	 */
	public function getAuthService($client)
	{
		return Auth::find()->where([
			'source' => $client->getId(),
			'source_id' => $this->attributes['id'],
		])->one();
	}

	/**
	 * Создаем новую запись в таблицу Auth заполняя ее данными пришедшими из внешнего сервиса
	 * @param object $client
	 * @param User $user
	 */
	public function setNewAuthService($client, User $user = null)
	{
		$this->auth_model = new Auth([
			'user_id' => !empty($user) ? $user->id : Yii::$app->user->id,
			'source' => $client->getId(),
			'source_id' => $this->attributes['id'],
		]);
		$this->auth_model->save();
	}

}
