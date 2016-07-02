<?php

namespace app\modules\realty\controllers;

use Yii;
use common\models\CommonQuery;
use common\models\realty\RealtyCat;
use common\models\realty\RealtyRent;
use common\models\realty\RealtyRentSearch;
use common\models\realty\RealtyRentImg;
use common\models\realty\VRealtyRent;
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
use yii\web\Response;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;

/**
 * RealtyController implements the CRUD actions for Realty model.
 */
class RentController extends Controller
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
		if ($action->id == 'create') {
			Yii::$app->user->loginUrl = ['/site/simply-reg', 'v' => 1];
		}
		return parent::beforeAction($action);
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'upload' => [
				'class' => 'denoll\filekit\actions\UploadAction',
				'fileStorage' => 'realtyRentStorage',
				'disableCsrf' => true,
				'responseFormat' => Response::FORMAT_JSON,
				'on afterSave' => function ($event) {
					/* @var $file \League\Flysystem\File */
					$file = $event->file;
					$path = Url::to('@frt_dir/img/realty_rent/' . $file->getPath());
					Image::thumbnail($path, 600, 400)
						->save($path, ['quality' => 80]);
				}
			],
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
		$searchModel = new RealtyRentSearch();
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
		if ((!$get['cat'] && !$get['RealtyRentSearch']['cat'])) {
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
		$model = VRealtyRent::find()->where(['id' => $id])->asArray()->one();
		RealtyCat::setSessionCategoryTree($model['alias']);
		$images = RealtyRentImg::find()->where(['id_ads' => $model['id']])->asArray()->all();
		return $this->render('view', [
			'model' => $model,
			'images' => $images,
		]);
	}

	/**
	 * Creates a new Service model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new RealtyRent(['scenario' => 'create']);
		$post = Yii::$app->request->post();
		if ($model->load($post)) {
			empty($post['RealtyRent']['distance']) ? $model->distance = 0 : $model->distance = $post['RealtyRent']['distance'];
			$model->id_user = Yii::$app->user->identity->getId();
			$model->status = 1;
			if ($model->save(false)) {
				\Yii::$app->session->setFlash('success', 'Объявление успешно создано.');
				CommonQuery::sendCreateAdsEmail(Yii::$app->user->identity->getId(), $model, Url::to('@frt_url/realty/rent/my-ads'));
				return $this->redirect(['my-ads', 'id' => $model->id]);
			} else {
				\Yii::$app->session->setFlash('danger', 'По каким-то причинам объявление создать не удалось.<br>Пожалуйста повторите попытку.');
			}
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
		$model = RealtyRent::find()->where(['id' => $id, 'id_user' => $user->getId()])->one();
		$post = Yii::$app->request->post();
		if ($model->load($post)) {
			empty($post['RealtyRent']['distance']) ? $model->distance = 0 : $model->distance = $post['RealtyRent']['distance'];
			if ($model->save()) {
				\Yii::$app->session->setFlash('success', 'Изменения успешно внесены.');
			} else {
				\Yii::$app->session->setFlash('danger', 'По каким-то причинам сохранить изменения не удалось.<br>Пожалуйста повторите попытку.');
			}
			return $this->render('update', ['model' => $model,]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	public function actionDelete($id)
	{
		$user_id = Yii::$app->user->identity->getId();
		$model = RealtyRent::findOne(['id' => $id, 'id_user' => $user_id]);
		if ($model->delete()) {
			CommonQuery::sendDeleteAdsEmail($user_id, $model, Url::to('@frt_url/realty/rent/my-ads'));
			return $this->redirect(['my-ads']);
		} else {
			\Yii::$app->session->setFlash('danger', 'Объявление не было удалено.');
			return $this->redirect(['update', 'id' => $id]);
		}
	}

	/**
	 * Lists all Service models.
	 * @return mixed
	 */
	public function actionMyAds()
	{
		$user = Yii::$app->user->getIdentity();
		$query = RealtyRent::find()->where(['id_user' => $user->getId()]);
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
	 * Проверка какие инпуты показывать в форме в зависимости от выбраной категории.
	 * @return mixed
	 */
	public function actionChangeElement()
	{
		$post = (integer)\Yii::$app->request->post('cat_id');
		if ($post) {
			$model = RealtyCat::findOne(['id' => $post]);
			$arr = [];
			if ($model->readonly == 1) {
				$arr['readonly'] = 'true';
			} else {
				$arr['readonly'] = 'false';
			}
			if ($model->area_home == 1) {
				$arr['area_home'] = 'show';
			} else {
				$arr['area_home'] = 'hide';
			}
			if ($model->area_land == 1) {
				$arr['area_land'] = 'show';
			} else {
				$arr['area_land'] = 'hide';
			}
			if ($model->floor == 1) {
				$arr['floor'] = 'show';
			} else {
				$arr['floor'] = 'hide';
			}
			if ($model->floor_home == 1) {
				$arr['floor_home'] = 'show';
			} else {
				$arr['floor_home'] = 'hide';
			}
			if ($model->comfort == 1) {
				$arr['comfort'] = 'show';
			} else {
				$arr['comfort'] = 'hide';
			}
			if ($model->repair == 1) {
				$arr['repair'] = 'show';
			} else {
				$arr['repair'] = 'hide';
			}
			if ($model->resell == 1) {
				$arr['resell'] = 'show';
			} else {
				$arr['resell'] = 'hide';
			}
			if ($model->type == 1) {
				$arr['type'] = 'show';
			} else {
				$arr['type'] = 'hide';
			}
			echo json_encode($arr);
		}
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
			$model = RealtyRent::findOne(['id' => $post, 'id_user' => $user->getId()]);
			if ($model->status == 1) {
				$model->status = 0;
			} else {
				$model->status = 1;
			}
			if ($model->save()) {
				echo $model->status == 1 ? 'all' : 'me';
				\Yii::$app->session->setFlash('success', 'Статус изменен.');
				CommonQuery::sendChangeStatusEmail($user->getId(), $model, Url::to('@frt_url/realty/rent/my-ads'));
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
			$model = RealtyRent::findOne(['id' => $post, 'id_user' => $user->getId()]);
			$u_account = new UserAccount();
			if ($user->account >= $pay['realty_up_pay']) {
				$model->updated_at = new Expression('NOW()');
				$u_account->id_user = $user->getId();
				$u_account->pay_out = $pay['realty_up_pay'];
				$u_account->invoice = 'REALTY-UP-' . $model->id . '-' . rand(10000, 99999);
				$u_account->date = new Expression('NOW()');
				$u_account->description = 'Поднятие объявления об аренде недвижимости №' . $model->id . '.';

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
						'pay' => $pay['realty_up_pay'],
						'date' => date('Y-m-d'),
						'message' => 'Объявление поднято на верх. С вашего счета списано ' . $pay['realty_up_pay'] . 'руб.',
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
			$model = RealtyRent::findOne(['id' => $post, 'id_user' => $user->getId()]);
			$u_account = new UserAccount();
			if ($user->account >= $pay['realty_vip_pay']) {
				$u_account->id_user = $user->getId();
				$u_account->pay_out = $pay['realty_vip_pay'];
				$u_account->invoice = 'REALTY-VIP-' . $model->id . '-' . rand(10000, 99999);
				$u_account->date = new Expression('NOW()');
				$u_account->description = 'Выделение объявления об аренде недвижимости №' . $model->id . '. На срок: ' . $period['vip'] . 'дней.';
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
						'pay' => $pay['realty_vip_pay'],
						'date' => date('Y-m-d'),
						'message' => 'Объявление выделено на ( ' . $period['vip'] . ' )дней и поднято на верх. С вашего счета списано ' . $pay['realty_vip_pay'] . 'руб.',
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
		if (($model = RealtyRent::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}