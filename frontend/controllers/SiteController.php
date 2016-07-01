<?php
namespace frontend\controllers;

use yii\bootstrap\Html;
use app\helpers\Texts;
use common\models\users\Company;
use common\models\users\UserAuthRealization;
use common\widgets\captcha\Captcha;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\CommonQuery;


/**
 * Site controller
 */
class SiteController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout', 'signup', 'signup-company'],
				'rules' => [
					[
						'actions' => ['signup'],
						'allow' => true,
						'roles' => ['?'],
					],
					[
						'actions' => ['logout', 'signup-company'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					//'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
			'auth' => [
				'class' => 'yii\authclient\AuthAction',
				'successCallback' => [$this, 'onAuthSuccess'],
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return mixed
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	public function onAuthSuccess($client)
	{
		$authorisation = new UserAuthRealization();
		$authorisation->oAuthorization($client);
	}

	/**
	 * Logs in a user.
	 *
	 * @return mixed
	 */
	public function actionLogin()
	{
		if (!\Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->redirect(Url::previous());
		} else {
			return $this->render('login', [
				'model' => $model,
			]);
		}
	}

	public function actionSimplyReg($v = 1){
		if (!\Yii::$app->user->isGuest) {
			return $this->redirect(Url::previous());
		}
		$model_signup = new SignupForm();
		$model_login = new LoginForm();
		$post = Yii::$app->request->post();
		if($post['action'] == 'signup'){
			if ($model_signup->load($post)) {
				//$captcha = new Captcha();
				$response = true; //$captcha->init(Yii::$app->request->post());
				if ($response) {
					if ($user = $model_signup->signup()) {
						if($user->company&&Yii::$app->user->login($user, 3600 * 24 * 30)){
							CommonQuery::sendCreateUserEmail(Yii::$app->user->identity);
							return $this->redirect('signup-company');
						}elseif(Yii::$app->user->login($user, 3600 * 24 * 30)) {
							$user =Yii::$app->user->identity;
							if($user->tel){
								Yii::$app->session->setFlash('info', '<h4>Вы успешно зарегистрировались на сайте.</h4>');
							}else{
								Yii::$app->getSession()->setFlash('info', [
									'<h3>Вы успешно зарегистрированы на сайте.</h3>
								<p>Для более полной информации, рекомендуем Вам указать еще свой телефон, '.Html::a('в своем профиле','/profile/default/index',['class'=>'btn btn-sm btn-info']).'</p>
								',
								]);
							}
							//Отправляем Email пользователю с регистрационными данными
							CommonQuery::sendCreateUserEmail($user);
							return $this->redirect(Url::previous());
						}
					}
				} else {
					Yii::$app->session->setFlash('success', '<h4>Вы не прошли проверку капчи.</h4>');
				}
			}
		}elseif($post['action'] == 'login'){
			if ($model_login->load(Yii::$app->request->post()) && $model_login->login()) {
				return $this->redirect(Url::previous());
			}
		}
		return $this->render('simply-reg',[
			'model_signup' => $model_signup,
			'model_login' => $model_login,
			'message' => Texts::getMessage($v),
		]);
	}

	/**
	 * Logs out the current user.
	 *
	 * @return mixed
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}

	/**
	 * Displays contact page.
	 *
	 * @return mixed
	 */
	public function actionContact()
	{
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
				Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
			} else {
				Yii::$app->session->setFlash('error', 'There was an error sending email.');
			}

			return $this->refresh();
		} else {
			return $this->render('contact', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Displays about page.
	 *
	 * @return mixed
	 */
	public function actionAbout()
	{
		return $this->render('about');
	}

	/**
	 * Signs user up.
	 *
	 * @return mixed
	 */
	public function actionSignup()
	{
		$model = new SignupForm();
		if ($model->load(Yii::$app->request->post())) {
			//$captcha = new Captcha();
			$response = true; //$captcha->init(Yii::$app->request->post());

			if ($response) {
				if ($user = $model->signup()) {
					if($user->company&&Yii::$app->user->login($user, 3600 * 24 * 30)){
						CommonQuery::sendCreateUserEmail(\Yii::$app->user->identity);
						return $this->redirect(['/firm/firm/update']);
					}elseif(Yii::$app->user->login($user, 3600 * 24 * 30)) {
						$user =Yii::$app->user->identity;
						if($user->tel){
							Yii::$app->session->setFlash('info', '<h4>Вы успешно зарегистрировались на сайте.</h4>');
						}else{
							Yii::$app->getSession()->setFlash('info', [
								'<h3>Вы успешно зарегистрированы на сайте.</h3>
								<p>Для более полной информации, рекомендуем Вам указать еще свой телефон, '.Html::a('в своем профиле','/profile/default/index',['class'=>'btn btn-sm btn-info']).'</p>
								',
							]);
						}
						//Отправляем Email пользователю с регистрационными данными
						CommonQuery::sendCreateUserEmail($user);
						return $this->redirect(Url::previous());
					}
				}
			} else {
				Yii::$app->session->setFlash('success', '<h4>Вы не прошли проверку капчи.</h4>');
			}
		}
		return $this->render('signup', [
			'model' => $model,
		]);
	}

	public function actionIsCompany($bool)
	{
		if($bool){
			Yii::$app->session->set('is_company',1);
		}else{
			Yii::$app->session->set('is_company',0);
		}
	}

	public function actionSignupCompany()
	{
		$user = Yii::$app->user->identity;
		return $this->render('signup-company',[
			'user' => $user,
			'company' => Company::findOne($user->id)
		]);
	}

	/**
	 * Requests password reset.
	 *
	 * @return mixed
	 */
	public function actionRequestPasswordReset()
	{
		$model = new PasswordResetRequestForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail()) {
				Yii::$app->session->setFlash('success', 'Проверьте свой email, на него должна прийти ссылка на смену пароля<br>ВНИМАНИЕ! Если письма в почтовом ящике нет проверьте папку спам.');

				return $this->goHome();
			} else {
				Yii::$app->session->setFlash('error', 'Извините, но по какойто причине отправить письмо на ваш email не удалось<br>Проверьте правильность указания email адреса.');
			}
		}

		return $this->render('requestPasswordResetToken', [
			'model' => $model,
		]);
	}

	/**
	 * Resets password.
	 *
	 * @param string $token
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionResetPassword($token)
	{
		try {
			$model = new ResetPasswordForm($token);
		} catch (InvalidParamException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
			Yii::$app->session->setFlash('success', 'Новый пароль был успешно сохранен.');

			return $this->goHome();
		}

		return $this->render('resetPassword', [
			'model' => $model,
		]);
	}
}
