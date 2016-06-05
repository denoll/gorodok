<?php

namespace app\modules\goods\controllers;

use common\behaviors\AuthBehavior;
use common\models\CommonQuery;
use common\models\goods\VGoods;
use Yii;
use common\models\goods\Goods;
use common\models\goods\GoodsCat;
use common\models\goods\GoodsSearch;
use common\models\users\User;
use common\models\users\UserAccount;
use yii\web\Controller;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\widgets\Arrays;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\helpers\Url;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['change-status', 'change-up', 'change-vip', 'my-ads', 'create', 'update', 'delete'],
				'rules' => [
					[
						'actions' => ['change-status', 'change-up', 'change-vip', 'create', 'my-ads', 'update', 'delete'],
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
	 * Lists all Goods models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new GoodsSearch();
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

	private function delSession()
	{
		$get = \Yii::$app->request->get();
		if (!$get['cat'] && !$get['GoodsSearch']['cat']) {
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
	 * Displays a single Goods model.
	 * @param string $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = VGoods::find()->where(['id' => $id])->asArray()->one();
		GoodsCat::setSessionCategoryTree($model['alias']);
		return $this->render('view', [
			'model' => $model,
		]);
	}

	/**
	 * Creates a new Goods model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		if(Yii::$app->user->isGuest){
			Url::remember();
			Yii::$app->session->setFlash('info',[
				'<h3>Приветствуем Вас на нашем сайте!</h3>
				<p>Для того чтобы подать объявление Вам нужно пройти быструю регисттрацию или войти на сайт, емли уже были зарегистрированы.</p>
				<p>Это совсем не долго. После входа на сайт Вы сразу попадете на страницу подачи объявления.</p>',
			]);
			return $this->redirect('/site/signup');
		}
		$model = new Goods(['scenario' => 'create']);
		if ($model->load(Yii::$app->request->post())) {
			$model->id_user = Yii::$app->user->identity->getId();
			$model->status = 1;
			$model->image = \yii\web\UploadedFile::getInstance($model, 'image');
			if ($model->validate()) {
				if ($model->save(false)) {
					\Yii::$app->session->setFlash('success', 'Объявление успешно создано.');
					CommonQuery::sendCreateAdsEmail(Yii::$app->user->identity->getId(), $model, Url::to('@frt_url/goods/my-ads'));
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
	 * Updates an existing Goods model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$user = Yii::$app->user->getIdentity();
		$model = Goods::find()->where(['id' => $id, 'id_user' => $user->getId()])->one();
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
	 * Deletes an existing Goods model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$user = Yii::$app->user->identity;
		$item = Goods::findOne($id);
		if ($user->id == $item->id_user) {
			if (CommonQuery::deleteItem($item, '@frt_dir/img/goods')) {
				CommonQuery::sendDeleteAdsEmail($user->getId(), $item, Url::to('@frt_url/goods/my-ads'));
			}
		}
		return $this->redirect(['my-ads']);
	}

	/**
	 * Lists all JobResume models.
	 * @return mixed
	 */
	public function actionMyAds()
	{
		$user = Yii::$app->user->getIdentity();
		$query = Goods::find()->where(['id_user' => $user->getId()]);
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
	 * Change status goods ads models.
	 * @return mixed
	 */
	public function actionChangeStatus()
	{
		$post = \Yii::$app->request->post('ads_id');
		if ($post) {
			$user = Yii::$app->user->getIdentity();
			$model = Goods::findOne(['id' => $post, 'id_user' => $user->getId()]);
			if ($model->status == 1) {
				$model->status = 0;
			} else {
				$model->status = 1;
			}
			if ($model->save()) {
				echo $model->status == 1 ? 'all' : 'me';
				\Yii::$app->session->setFlash('success', 'Статус изменен.');
				CommonQuery::sendChangeStatusEmail($user->getId(), $model, Url::to('@frt_url/goods/my-ads'));
			} else {
				\Yii::$app->session->setFlash('danger', 'Статус не изменен.');
			}
		}
	}

	/**
	 * Поднятие объявления updated_at Goods models.
	 * @return mixed
	 */
	public function actionChangeUp()
	{
		$pay = Arrays::PAYMENTS(); // Payment sum
		$post = \Yii::$app->request->post('ads_id');
		if ($post) {
			$user = Yii::$app->user->getIdentity();
			$model = Goods::findOne(['id' => $post, 'id_user' => $user->getId()]);
			$u_account = new UserAccount();
			if ($user->account >= $pay['goods_up_pay']) {
				$model->updated_at = new Expression('NOW()');
				$u_account->id_user = $user->getId();
				$u_account->pay_out = $pay['goods_up_pay'];
				$u_account->invoice = 'GOODS-UP-' . $model->id . '-' . rand(10000, 99999);
				$u_account->date = new Expression('NOW()');
				$u_account->description = 'Поднятие объявления о товаре №' . $model->id . '.';

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
						'pay' => $pay['goods_up_pay'],
						'date' => date('Y-m-d'),
						'message' => 'Объявление поднято на верх. С вашего счета списано ' . $pay['goods_up_pay'] . 'руб.',
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
	 * Выделение и поднятие объявления vip, updated_at в JobResume models.
	 * @return mixed
	 */
	public function actionChangeVip()
	{
		$pay = Arrays::PAYMENTS();
		$period = Arrays::getConst();
		$post = \Yii::$app->request->post('ads_id');
		if ($post) {
			$user = Yii::$app->user->getIdentity();
			$model = Goods::findOne(['id' => $post, 'id_user' => $user->getId()]);
			$u_account = new UserAccount();
			if ($user->account >= $pay['goods_vip_pay']) {
				$u_account->id_user = $user->getId();
				$u_account->pay_out = $pay['goods_vip_pay'];
				$u_account->invoice = 'GOODS-VIP-' . $model->id . '-' . rand(10000, 99999);
				$u_account->date = new Expression('NOW()');
				$u_account->description = 'Выделение объявления о товаре №' . $model->id . '. На срок: ' . $period['vip'] . 'дней.';
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
						'pay' => $pay['goods_vip_pay'],
						'date' => date('Y-m-d'),
						'message' => 'Объявление выделено на ( ' . $period['vip'] . ' )дней и поднято на верх. С вашего счета списано ' . $pay['goods_vip_pay'] . 'руб.',
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
	 * @return Goods the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Goods::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
