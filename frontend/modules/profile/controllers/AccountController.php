<?php

namespace app\modules\profile\controllers;

use Yii;
use common\models\users\User;
use common\models\users\UserAccount;
use common\models\users\UserAccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\profile\yandex\Settings as Settings;
use app\modules\profile\yandex\YaMoneyCommonHttpProtocol;

/**
 * AccountController implements the CRUD actions for UserAccount model.
 */
class AccountController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['index', 'pay', 'success', 'fail', 'check-order', 'payment-aviso'],
				'rules' => [
					[
						'actions' => ['index', 'pay', 'success', 'fail'],
						'allow' => true,
						'roles' => ['@'],
					],
					[
						'actions' => ['check-order', 'payment-aviso'],
						'allow' => true,
						'roles' => ['?', '@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	public function beforeAction($action)
	{
		if ($action->id === 'check-order' || $action->id === 'payment-aviso' || $action->id === 'pay') {
			$this->enableCsrfValidation = false;
		}
		return parent::beforeAction($action);
	}

	/**
	 * Lists all UserAccount models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new UserAccountSearch();
		$dataProvider = $searchModel;
		$settings = new Settings();
		User::paymentsSumUpdate(Yii::$app->user->id);
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'settings' => $settings,
		]);
	}

	/**
	 * Creates a new UserAccount model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionPay()
	{
		$model = new UserAccount();
		$user = Yii::$app->user->getIdentity();
		$settings = new Settings();
		$orderNumber = 'Y-' . $user['id'] . '-' . time();
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('pay', [
				'orderNumber' => $orderNumber,
				'model' => $model,
				'user' => $user,
				'settings' => $settings,
			]);
		}
	}

	public function actionPaymentAviso()
	{
		$settings = new Settings();
		$yaMoneyCommonHttpProtocol = new YaMoneyCommonHttpProtocol($settings);
		print $yaMoneyCommonHttpProtocol->paymentAviso(Yii::$app->request->post());
	}

	public function actionCheckOrder()
	{
		$settings = new Settings();
		$yaMoneyCommonHttpProtocol = new YaMoneyCommonHttpProtocol($settings);
		print $yaMoneyCommonHttpProtocol->checkOrder(Yii::$app->request->post());
	}

	public function actionCheckPost()
	{
		return $this->render('check-post');
	}


	public function actionSuccess()
	{
		return $this->render('success', []);
	}

	public function actionFail()
	{
		return $this->render('fail', []);
	}

	/**
	 * Finds the UserAccount model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return UserAccount the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = UserAccount::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
