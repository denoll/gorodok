<?php

namespace app\modules\auto\controllers;

use common\models\auto\AutoImg;
use common\models\auto\AutoModels;
use common\models\auto\AutoModify;
use common\models\auto\S;
use common\models\CommonQuery;
use common\models\users\Query;
use common\models\users\User;
use common\models\users\UserAccount;
use common\widgets\Arrays;
use common\widgets\buttons\ControllerButton;
use Yii;
use yii\data\Pagination;
use yii\db\Expression;
use yii\helpers\Url;
use common\models\auto\AutoItem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\filters\AccessControl;

/**
 * ItemController implements the CRUD actions for AutoItem model.
 */
class ItemController extends Controller
{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only'  => [ 'change-status', 'change-up', 'change-vip', 'my-auto', 'create', 'update', 'delete-item' ],
				'rules' => [
					[
						'actions' => [ 'change-status', 'change-up', 'change-vip', 'create', 'my-auto', 'update', 'delete-item' ],
						'allow'   => true,
						'roles'   => [ '@' ],
					],
				],
			],
			'verbs'  => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'delete-item' => [ 'POST' ],
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
				'class'          => 'denoll\filekit\actions\UploadAction',
				'fileStorage'    => 'autoStorage',
				'disableCsrf'    => true,
				//'deleteRoute' => 'delete-img',
				//'responseDeleteUrlParam' => Url::to('/auto/item/delete-img'),
				'responseFormat' => Response::FORMAT_JSON,
				'on afterSave'   => function ($event) {
					/* @var $file \League\Flysystem\File */
					$file = $event->file;
					$path = Url::to('@frt_dir/img/auto/' . $file->getPath());
					Image::thumbnail($path, 600, 400)
						->save($path, [ 'quality' => 80 ]);
				},
			],
			'delete' => [
				'class'       => 'denoll\filekit\actions\DeleteAction',
				'fileStorage' => 'autoStorage',
			],
			'error'  => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	/**
	 * Lists all AutoItem models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new S();
		$search = $searchModel->search(Yii::$app->request->queryParams);
		Url::remember();
		if ( $search ) {
			$dataProvider = $search;
			return $this->render('index', [
				'items'        => true,
				'searchModel'  => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		} else {
			return $this->render('index', [
				'items' => false,
			]);
		}
	}

	/**
	 * Displays a single AutoItem model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModelAllUsers((int)$id),
		]);
	}


	/**
	 * Creates a new AutoItem model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new AutoItem(['scenario' => 'create']);
		if ( $model->load(Yii::$app->request->post()) ) {
			$model->id_user = Yii::$app->user->id;
			$model->status = AutoItem::STATUS_ACTIVE;
			$model->save();
			return ControllerButton::widget([
				'action'     => Yii::$app->request->post('action'),
				'save_url'   => Url::previous(),
				'update_url' => '/auto/item/update',
				'id'         => $model->id,
			]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing AutoItem model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		if ( $model->load(Yii::$app->request->post()) && $model->save() ) {
			return ControllerButton::widget([
				'action'     => Yii::$app->request->post('action'),
				'save_url'   => Url::previous(),
				'update_url' => '/auto/item/update',
				'id'         => $model->id,
			]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing AutoItem model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDeleteItem($id)
	{
		$model = $this->findModel($id);
		$images = AutoImg::find()->where([ 'id_item' => $id ])->all();
		$path = Url::to('@frt_dir/img/auto/');
		if ( $images ) {
			foreach ( $images as $item ) {
				$file = $path . $item->path;
				if ( file_exists($file) ) {
					unlink($file);
				}
			}
		}
		$model->delete();
		return $this->redirect([ 'index' ]);
	}


	/**
	 * @param $id_brand
	 * @return null
	 */
	public function actionGetModel($id_brand)
	{
		$id_brand = (int)$id_brand;
		if ( !$id_brand ) echo '<option value="0">Выберите модель... </option>';
		/** @var AutoModels $model */
		$model = AutoModels::find()->where([ 'status' => AutoModels::STATUS_ACTIVE, 'brand_id' => $id_brand ])->all();
		echo '<option value="0">Выберите модель... </option>';
		foreach ( $model as $item ) {
			echo '<option value="' . $item->id . '">' . $item->name . '</option>';
		}
	}


	/**
	 * Lists all AutoItem models.
	 * @return mixed
	 */
	public function actionMyAuto()
	{
		$user = Yii::$app->user->getIdentity();
		$query = AutoItem::find()->with([ 'brand', 'model' ])->where([ 'id_user' => $user->getId() ]);
		$countQuery = clone $query;
		$pages = new Pagination([ 'totalCount' => $countQuery->count() ]);
		$model = $query->offset($pages->offset)
			->limit($pages->limit)
			->all();

		return $this->render('my-auto', [
			'user'  => $user,
			'model' => $model,
			'pages' => $pages,
		]);
	}

	/**
	 * Change status AutoItem ads models.
	 * @return mixed
	 */
	public function actionChangeStatus()
	{
		$post = (int)\Yii::$app->request->post('ads_id');
		if ( $post ) {
			$user = Yii::$app->user->getIdentity();
			$model = AutoItem::find()->with([ 'brand', 'model', 'user' ])->where([ 'id' => $post, 'id_user' => $user->getId() ])->one();
			if ( $model->status == 1 ) {
				$model->status = 0;
			} else {
				$model->status = 1;
			}
			if ( $model->save() ) {
				echo $model->status == 1 ? 'all' : 'me';
				\Yii::$app->session->setFlash('success', 'Статус изменен.');
				CommonQuery::sendChangeAutoStatusEmail($user->getId(), $model, Url::to('@frt_url/my-auto'));
			} else {
				\Yii::$app->session->setFlash('danger', 'Статус не изменен.');
			}
		}
	}

	/**
	 * Поднятие объявления updated_at AutoItem models.
	 * @return mixed
	 */
	public function actionChangeUp()
	{
		/** @var $model AutoItem */
		/** @var $u_account UserAccount */
		$pay = Arrays::PAYMENTS(); // Payment sum
		$post = (int)\Yii::$app->request->post('ads_id');
		if ( $post ) {
			$user = Yii::$app->user->getIdentity();
			$model = AutoItem::find()->with([ 'brand', 'model' ])->where([ 'id' => $post, 'id_user' => $user->getId() ])->one();
			$u_account = new UserAccount();
			if ( $user->account >= $pay[ 'auto_up_pay' ] ) {
				$model->updated_at = new Expression('NOW()');
				$u_account->id_user = $user->getId();
				$u_account->pay_out = $pay[ 'auto_up_pay' ];
				$u_account->invoice = 'AUTO-UP-' . $model->id . '-' . rand(10000, 9999999);
				$u_account->date = new Expression('NOW()');
				$u_account->description = 'Поднятие объявления о продаже автомобиля №' . $model->id . '.  ' . $model->brand->name . ' - ' . $model->model->name;

				$payment = [
					'invoice'     => $u_account->invoice,
					'pay_out'     => $u_account->pay_out,
					'date'        => date('Y-m-d'),
					'service'     => $u_account->description,
					'description' => $u_account->description,
				];
				if ( $model->save() && $u_account->save() && Query::userPayOut($user->id, $u_account->pay_out) ) {
					$m_user = User::findOne($user->getId());
					$payment[ 'account' ] = $m_user->account;
					CommonQuery::sendPayOutEmail($user->id, $payment);
					$arr = [
						'account' => $m_user->account,
						'pay'     => $pay[ 'auto_up_pay' ],
						'date'    => date('Y-m-d'),
						'message' => 'Объявление поднято на верх. С вашего счета списано ' . $pay[ 'auto_up_pay' ] . 'руб.',
						'm_type'  => 'success',
					];
					echo json_encode($arr);
				} else {
					$arr = [
						'message' => 'Объявление не поднято',
						'm_type'  => 'danger',
					];
					echo json_encode($arr);
				}
			} else {
				$arr = [
					'message' => 'Объявление не поднято. На вашем счёте недостаточно средств.',
					'm_type'  => 'danger',
				];
				echo json_encode($arr);
			}

		}
	}

	/**
	 * Выделение и поднятие объявления vip, updated_at в AutoItem models.
	 * @return mixed
	 */
	public function actionChangeVip()
	{
		/** @var $model AutoItem */
		/** @var $u_account UserAccount */
		$pay = Arrays::PAYMENTS();
		$period = Arrays::getConst();
		$post = (int)\Yii::$app->request->post('ads_id');
		if ( $post ) {
			$user = Yii::$app->user->getIdentity();
			$model = AutoItem::find()->with([ 'brand', 'model' ])->where([ 'id' => $post, 'id_user' => $user->getId() ])->one();
			$u_account = new UserAccount();
			if ( $user->account >= $pay[ 'auto_vip_pay' ] ) {
				$u_account->id_user = $user->getId();
				$u_account->pay_out = $pay[ 'auto_vip_pay' ];
				$u_account->invoice = 'AUTO-VIP-' . $model->id . '-' . rand(10000, 9999999);
				$u_account->date = new Expression('NOW()');
				$u_account->description = 'Выделение объявления о продаже авто №' . $model->id . '.  ' . $model->brand->name . ' - ' . $model->model->name . '. На срок: ' . $period[ 'vip' ] . 'дней.';
				$model->vip_date = new Expression('NOW()');
				$model->updated_at = new Expression('NOW()');
				$payment = [
					'invoice'     => $u_account->invoice,
					'pay_out'     => $u_account->pay_out,
					'date'        => date('Y-m-d'),
					'service'     => $u_account->description,
					'description' => $u_account->description,
				];

				if ( $model->save() && $u_account->save() && Query::userPayOut($user->id, $u_account->pay_out) ) {
					$m_user = User::findOne($user->id);
					$payment[ 'account' ] = $m_user->account;
					CommonQuery::sendPayOutEmail($user->id, $payment);
					$arr = [

						'account' => $m_user->account,
						'pay'     => $pay[ 'auto_vip_pay' ],
						'date'    => date('Y-m-d'),
						'message' => 'Объявление выделено на ( ' . $period[ 'vip' ] . ' )дней и поднято на верх. С вашего счета списано ' . $pay[ 'auto_vip_pay' ] . 'руб.',
						'm_type'  => 'success',
					];
					echo json_encode($arr);
				} else {
					$arr = [
						'message' => 'Объявление не выделено и не поднято.',
						'm_type'  => 'danger',
					];
					echo json_encode($arr);
				}
			} else {
				$arr = [
					'message' => 'Объявление не выделено и не поднято. На вашем счёте недостаточно средств.',
					'm_type'  => 'danger',
				];
				echo json_encode($arr);
			}

		}
	}

	/**
	 * Finds the AutoItem model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return AutoItem the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if ( ($model = AutoItem::find()->with([ 'brand', 'model' ])->where(['id'=>$id, 'id_user'=>Yii::$app->user->id])->one()) !== null ) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	/**
	 * Finds the AutoItem model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return AutoItem the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModelAllUsers($id)
	{
		if ( ($model = AutoItem::find()->with([ 'brand', 'model', 'autoImg', 'user'])->where(['id'=>$id, 'status'=>AutoItem::STATUS_ACTIVE])->one()) !== null ) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
