<?php

namespace app\modules\account\controllers;

use common\models\CommonQuery;
use common\models\users\User;
use Yii;
use common\models\users\UserAccount;
use common\models\users\BUserAccountSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccountController implements the CRUD actions for UserAccount model.
 */
class AccountController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all UserAccount models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new BUserAccountSearch();
		$dataProvider = $searchModel;
		Url::remember(Url::current(), 'account');
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single UserAccount model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new UserAccount model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new UserAccount();

		$post = Yii::$app->request->post();
		if ($model->load($post)) {
			$user_id = $post['UserAccount']['id_user'];
			$payment = [
				'invoice' => 'B-' . $user_id . '-' . time(),
				'pay_in' => $post['UserAccount']['pay_in'],
				'date' => date('Y-m-d')
			];
			$model->invoice = $payment['invoice'];
			if(trim($model->description) == '' || trim($model->description) == null){
				$model->description = $model->service;
			}
			$model->pay_in_with_percent = $model->pay_in;
			$model->save();
			CommonQuery::userAccontUpdateSum($user_id);
			CommonQuery::sendPayInEmail($user_id, $payment);
			return $this->redirect(Url::previous('account'));
		} else {
			return $this->render('create', [
				'model' => $model,
				'users' => User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all(),
			]);
		}
	}

	/**
	 * Updates an existing UserAccount model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$post = Yii::$app->request->post();
		if ($model->load($post)) {
			$user_id = $post['UserAccount']['id_user'];
			$model->pay_in_with_percent = $model->pay_in;
			if(trim($model->description) == '' || trim($model->description) == null){
				$model->description = $model->service;
			}
			$model->save();
			CommonQuery::userAccontUpdateSum($user_id);
			return $this->redirect(Url::previous('account'));
		} else {
			return $this->render('update', [
				'model' => $model,
				'users' => User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all(),
			]);
		}
	}

	/**
	 * Deletes an existing UserAccount model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$payment = $this->findModel($id);
		$user_id = $payment->id_user;
		if ($payment->delete()) {
			CommonQuery::userAccontUpdateSum($user_id);
		}
		return $this->redirect(['index']);
	}

	/**
	 * Finds the UserAccount model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
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
