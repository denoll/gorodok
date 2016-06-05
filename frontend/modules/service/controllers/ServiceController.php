<?php

namespace app\modules\service\controllers;

use Yii;
use yii\helpers\Url;
use common\models\CommonQuery;
use common\models\service\Service;
use common\models\service\ServiceCat;
use common\models\service\ServiceSearch;
use common\models\service\ServiceBuySearch;
use common\models\service\VService;
use common\models\service\VServiceBuy;
use common\models\users\User;
use common\models\users\UserAccount;
use yii\web\Controller;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\widgets\Arrays;
use yii\filters\AccessControl;
use yii\data\Pagination;

/**
 * ServiceController implements the CRUD actions for Service model.
 */
class ServiceController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['change-status', 'change-up', 'change-vip', 'my-ads', 'create', 'update', 'delete'],
				'rules' => [
					[
						'actions' => ['change-status', 'change-up', 'change-vip', 'my-ads', 'create', 'update', 'delete'],
						'allow' => true,
						'roles' => ['@'],
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
		if($action->id == 'create'){
			Yii::$app->user->loginUrl = ['/site/simply-reg','v'=>1];
		}
		return parent::beforeAction($action);
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
		];
	}

	/**
	 * Lists all Service models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new ServiceSearch();
		$search = $searchModel->search(Yii::$app->request->queryParams);
		$this->delSession();
		if ($search) {
			$dataProvider = $search;
			return $this->render('index', [
				'items' => true,
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		} else {
			return $this->render('index', [
				'items' => false,
			]);
		}
	}

	/**
	 * Lists all ServiceBuy models. Объявления на запрос услуг
	 * @return mixed
	 */
	public function actionIndexBuy()
	{
		$searchModel = new ServiceBuySearch();
		$search = $searchModel->search(Yii::$app->request->queryParams);
		$this->delSession();
		if ($search) {
			$dataProvider = $search;
			return $this->render('index-buy', [
				'items' => true,
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		} else {
			return $this->render('index-buy', [
				'items' => false,
			]);
		}
	}

	private function delSession()
	{
		$get = \Yii::$app->request->get();
		if ((!$get['cat'] && !$get['ServiceSearch']['cat']) || (!$get['cat'] && !$get['ServiceBuySearch']['cat'])) {
			$ses = Yii::$app->session;
			$ses->open();
			$ses->set('current_cat', null);
			$ses->set('parent_cat', null);
			$ses->set('cat_child', null);
			$ses->set('first_child', null);
			$ses->close();
		}
	}

	/**
	 * Displays a single VService model.
	 * @param string $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = VService::find()->where(['id' => $id])->asArray()->one();
		ServiceCat::setSessionCategoryTree($model['alias']);
		return $this->render('view', [
			'model' => $model,
		]);
	}

	/**
	 * Displays a single VServiceBuy model.
	 * @param string $id
	 * @return mixed
	 */
	public function actionViewBuy($id)
	{
		$model = VServiceBuy::find()->where(['id' => $id])->asArray()->one();
		ServiceCat::setSessionCategoryTree($model['alias']);
		return $this->render('view-buy', [
			'model' => $model,
		]);
	}

	/**
	 * Creates a new Service model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Service(['scenario' => 'create']);
		if ($model->load(Yii::$app->request->post())) {
			$model->id_user = Yii::$app->user->identity->getId();
			$model->status = 1;
			$model->image = \yii\web\UploadedFile::getInstance($model, 'image');
			if ($model->validate()) {
				if ($model->save(false)) {
					\Yii::$app->session->setFlash('success', 'Объявление успешно создано.');
					CommonQuery::sendCreateAdsEmail(Yii::$app->user->identity->getId(), $model, Url::to('@frt_url/service/my-ads'));
					return $this->redirect(['my-ads', 'id' => $model->id]);
				} else {
					\Yii::$app->session->setFlash('danger', 'По каким-то причинам объявление создать не удалось.<br>Пожалуйста повторите попытку.');
				}
			}
			//$model->id_cat = null;
			return $this->render('create', ['model' => $model,]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Service model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$user = Yii::$app->user->getIdentity();
		$model = Service::find()->where(['id' => $id, 'id_user' => $user->getId()])->one();
		if ($model->load(Yii::$app->request->post())) {
			$model->image = \yii\web\UploadedFile::getInstance($model, 'image');
			if ($model->validate()) {
				if ($model->save()) {
					\Yii::$app->session->setFlash('success', 'Изменения успешно внесены.');
					return $this->redirect(['my-ads', 'id' => $model->id]);
				} else {
					\Yii::$app->session->setFlash('danger', 'По каким-то причинам сохранить изменения не удалось.<br>Пожалуйста повторите попытку.');
				}
			}
			//$model->id_cat = null;
			return $this->render('update', ['model' => $model,]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Service model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$user = Yii::$app->user->identity;
		$item = Service::findOne($id);
		if ($user->id == $item->id_user) {
			if (CommonQuery::deleteItem($item, '@frt_dir/img/service')) {
				CommonQuery::sendDeleteAdsEmail($user->getId(), $item, Url::to('@frt_url/service/my-ads'));
			}
		}
		return $this->redirect(['my-ads']);
	}

	/**
	 * Lists all Service models.
	 * @return mixed
	 */
	public function actionMyAds()
	{
		$user = Yii::$app->user->getIdentity();
		$query = Service::find()->where(['id_user' => $user->getId()]);
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count()]);
		$model = $query->offset($pages->offset)
			->limit($pages->limit)
			->all();

		return $this->render('my-ads', [
			'user' => $user,
			'model' => $model,
			'pages' => $pages,
		]);
	}

	/**
	 * Change status Service ads models.
	 * @return mixed
	 */
	public function actionChangeStatus()
	{
		$post = \Yii::$app->request->post('ads_id');
		if ($post) {
			$user = Yii::$app->user->getIdentity();
			$model = Service::findOne(['id' => $post, 'id_user' => $user->getId()]);
			if ($model->status == 1) {
				$model->status = 0;
			} else {
				$model->status = 1;
			}
			if ($model->save()) {
				echo $model->status == 1 ? 'all' : 'me';
				\Yii::$app->session->setFlash('success', 'Статус изменен.');
				CommonQuery::sendChangeStatusEmail($user->getId(), $model, Url::to('@frt_url/service/my-ads'));
			} else {
				\Yii::$app->session->setFlash('danger', 'Статус не изменен.');
			}
		}
	}

	/**
	 * Поднятие объявления updated_at Service models.
	 * @return mixed
	 */
	public function actionChangeUp()
	{
		$pay = Arrays::PAYMENTS();
		$post = \Yii::$app->request->post('ads_id');
		if ($post) {
			$user = Yii::$app->user->getIdentity();
			$model = Service::findOne(['id' => $post, 'id_user' => $user->getId()]);

			$u_account = new UserAccount();
			if ($user->account >= $pay['service_up_pay']) {
				$model->updated_at = new Expression('NOW()');
				$u_account->id_user = $user->getId();
				$u_account->pay_out = $pay['service_up_pay'];
				$u_account->invoice = 'SERVICE-UP-' . $model->id . '-' . rand(10000, 99999);
				$u_account->date = new Expression('NOW()');
				$u_account->description = 'Поднятие объявления об услуге №' . $model->id . '.';

				$payment = [
					'invoice' => $u_account->invoice,
					'pay_out' => $u_account->pay_out,
					'date' => date('Y-m-d'),
					'service' => $u_account->description,
					'description' => $u_account->description,
				];
				if ($model->save() && $u_account->save() && CommonQuery::userAccontUpdateSum($user->id)) {
					$m_user = User::findOne($user->getId());
					$payment['account'] = $m_user->account;
					CommonQuery::sendPayOutEmail($user->id, $payment);
					$arr = [
						'account' => $m_user->account,
						'pay' => $pay['service_up_pay'],
						'date' => date('Y-m-d'),
						'message' => 'Объявление поднято на верх. С вашего счета списано ' . $pay['service_up_pay'] . 'руб.',
						'm_type' => 'success'
					];
					echo json_encode($arr);
				} else {
					$arr = [
						'message' => 'Объявление не поднято',
						'm_type' => 'danger'
					];
					echo json_encode($arr);
				}
			} else {
				$arr = [
					'message' => 'Объявление не поднято. На вашем счёте недостаточно средств.',
					'm_type' => 'danger'
				];
				echo json_encode($arr);
			}

		}
	}

	/**
	 * Выделение и поднятие объявления vip, updated_at в service models.
	 * @return mixed
	 */
	public function actionChangeVip()
	{
		$pay = Arrays::PAYMENTS();
		$period = Arrays::getConst();
		$post = \Yii::$app->request->post('ads_id');
		if ($post) {
			$user = Yii::$app->user->getIdentity();
			$model = Service::findOne(['id' => $post, 'id_user' => $user->getId()]);
			$u_account = new UserAccount();
			if ($user->account >= $pay['service_vip_pay']) {
				$u_account->id_user = $user->getId();
				$u_account->pay_out = $pay['service_vip_pay'];
				$u_account->invoice = 'SERVICE-VIP-' . $model->id . '-' . rand(10000, 99999);
				$u_account->date = new Expression('NOW()');
				$u_account->description = 'Выделение объявления об услуге №' . $model->id . '. На срок: ' . $period['vip'] . 'дней.';
				$model->vip_date = new Expression('NOW()');
				$model->updated_at = new Expression('NOW()');

				$payment = [
					'invoice' => $u_account->invoice,
					'pay_out' => $u_account->pay_out,
					'date' => date('Y-m-d'),
					'service' => $u_account->description,
					'description' => $u_account->description,
				];

				if ($model->save() && $u_account->save() && CommonQuery::userAccontUpdateSum($user->id)) {
					$m_user = User::findOne($user->getId());
					$payment['account'] = $m_user->account;
					CommonQuery::sendPayOutEmail($user->id, $payment);
					$arr = [
						'account' => $m_user->account,
						'pay' => $pay['service_vip_pay'],
						'date' => date('Y-m-d'),
						'message' => 'Объявление выделено на ( ' . $period['vip'] . ' )дней и поднято на верх. С вашего счета списано ' . $pay['service_vip_pay'] . 'руб.',
						'm_type' => 'success'
					];
					echo json_encode($arr);
				} else {
					$arr = [
						'message' => 'Объявление не выделено и не поднято.',
						'm_type' => 'danger'
					];
					echo json_encode($arr);
				}
			} else {
				$arr = [
					'message' => 'Объявление не выделено и не поднято. На вашем счёте недостаточно средств.',
					'm_type' => 'danger'
				];
				echo json_encode($arr);
			}

		}
	}

	/**
	 * Finds the Goods model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return Service the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Service::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
