<?php

namespace app\modules\jobs\controllers;

use common\models\CommonQuery;
use common\models\jobs\JobCategory;
use common\models\jobs\JobCatRez;
use common\models\users\User;
use common\models\users\UserAccount;
use common\models\users\UserEdu;
use common\models\users\UserExp;
use Yii;
use common\models\jobs\JobResume;
use common\models\jobs\JobResumeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\SeoFunc;
use yii\db\Expression;
use common\widgets\Arrays;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * ResumeController implements the CRUD actions for JobResume model.
 */
class ResumeController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['my-resume', 'change-status', 'change-up', 'change-vip', 'create', 'update', 'cat-del', 'delete'],
				'rules' => [
					[
						'actions' => ['my-resume', 'change-status', 'change-up', 'change-vip', 'create', 'update', 'cat-del', 'delete'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	public function beforeAction($action)
	{
		if ($action->id == 'create') {
			Yii::$app->user->loginUrl = ['/site/simply-reg', 'v' => 2];
		}
		return parent::beforeAction($action);
	}

	/**
	 * Lists all JobResume models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new JobResumeSearch();
		$search = $searchModel->search(Yii::$app->request->queryParams);

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
	 * Displays a single JobResume model.
	 * @param string $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$res = JobResume::find()->where(['id' => $id])->asArray()->one();
		$user = User::find()->with('profile')->where(['id' => $res['id_user']])->asArray()->one();
		$edu = UserEdu::find()->where(['id_user' => $res['id_user']])->orderBy('end_time DESC')->asArray()->all();
		$exp = UserExp::find()->where(['id_user' => $res['id_user']])->asArray()->all();
		return $this->render('view', [
			'res' => $res,
			'user' => $user,
			'edu' => $edu,
			'exp' => $exp,
		]);
	}

	/**
	 * Lists all JobResume models.
	 * @return mixed
	 */
	public function actionMyResume()
	{
		$user = Yii::$app->user->getIdentity();
		if (!$user['company']) {
			$model = JobResume::find()->asArray()->where(['id_user' => $user->getId()])->all();
			return $this->render('my-resume', [
				'user' => $user,
				'model' => $model,
			]);
		} else {
			\Yii::$app->session->setFlash('info', 'Для подачи резюме Вы должны зарегистрироваться как частное лицо.');
			return $this->redirect(Url::home());
		}
	}

	/**
	 * Change status JobResume models.
	 * @return mixed
	 */
	public function actionChangeStatus()
	{
		$post = \Yii::$app->request->post('res_id');
		if ($post) {
			$user = Yii::$app->user->getIdentity();
			$model = JobResume::findOne(['id' => $post, 'id_user' => $user->getId()]);
			if ($model->status == 1) {
				$model->status = 0;
			} else {
				$model->status = 1;
			}
			if ($model->save()) {
				echo $model->status == 1 ? 'all' : 'me';
				\Yii::$app->session->setFlash('success', 'Статус изменен.');
				CommonQuery::sendChangeStatusEmail($user->getId(), $model, Url::to('@frt_url/jobs/resume/my-resume'));
			} else {
				\Yii::$app->session->setFlash('danger', 'Статус не изменен.');
			}
		}
	}

	/**
	 * Поднятие объявления updated_at JobResume models.
	 * @return mixed
	 */
	public function actionChangeUp()
	{
		$pay = Arrays::PAYMENTS();
		$post = \Yii::$app->request->post('res_id');
		if ($post) {
			$user = Yii::$app->user->getIdentity();
			$model = JobResume::findOne(['id' => $post, 'id_user' => $user->getId()]);
			$u_account = new UserAccount();
			if ($user->account >= $pay['res_up_pay']) {
				$model->updated_at = new Expression('NOW()');
				$u_account->id_user = $user->getId();
				$u_account->pay_out = $pay['res_up_pay'];
				$u_account->invoice = 'RES-UP-' . $model->id . '-' . rand(10000, 99999);
				$u_account->date = new Expression('NOW()');
				$u_account->description = 'Поднятие резюме №' . $model->id . '.';

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
						'pay' => $pay['res_up_pay'],
						'date' => date('Y-m-d'),
						'message' => 'Резюме поднято на верх. С вашего счета списано ' . $pay['res_up_pay'] . 'руб.',
						'm_type' => 'success'
					];
					echo json_encode($arr);
				} else {
					$arr = [
						'message' => 'Резюме не поднято',
						'm_type' => 'danger'
					];
					echo json_encode($arr);
				}
			} else {
				$arr = [
					'message' => 'Резюме не поднято. На вашем счёте недостаточно средств.',
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
		$post = \Yii::$app->request->post('res_id');
		if ($post) {
			$user = Yii::$app->user->getIdentity();
			$model = JobResume::findOne(['id' => $post, 'id_user' => $user->getId()]);
			$u_account = new UserAccount();
			if ($user->account >= $pay['res_vip_pay']) {

				$u_account->id_user = $user->getId();
				$u_account->pay_out = $pay['res_vip_pay'];
				$u_account->invoice = 'RES-VIP-' . $model->id . '-' . rand(10000, 99999);
				$u_account->date = new Expression('NOW()');
				$u_account->description = 'Выделение резюме №' . $model->id . '.';
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
						'pay' => $pay['res_vip_pay'],
						'date' => date('Y-m-d'),
						'message' => 'Резюме выделено на ( ' . $period['vip'] . ' )дней и поднято на верх. С вашего счета списано ' . $pay['res_vip_pay'] . 'руб.',
						'm_type' => 'success'
					];
					echo json_encode($arr);
				} else {
					$arr = [
						'message' => 'Резюме не выделено и не поднято.',
						'm_type' => 'danger'
					];
					echo json_encode($arr);
				}
			} else {
				$arr = [
					'message' => 'Резюме не выделено и не поднято. На вашем счёте недостаточно средств.',
					'm_type' => 'danger'
				];
				echo json_encode($arr);
			}

		}
	}


	/**
	 * Creates a new JobResume model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$user = Yii::$app->user->getIdentity();
		if (!$user['company']) {
			$model = new JobResume();
			$post = \Yii::$app->request->post();
			if ($model->load($post)) {
				$user_id = \Yii::$app->user->identity->getId();
				$model->id_user = $user_id;
				$model->m_description = $this->genDescription($post['JobResume']['title'], $post['JobResume']['description']);
				if ($post['cbx']) {
					$model->m_keyword = $this->genKeywords($post['cbx'], $post['JobResume']['description']);
				}
				if ($model->save()) {
					\Yii::$app->session->setFlash('success', 'Изменения успешно внесены.');
				} else {
					\Yii::$app->session->setFlash('danger', 'Внести изменения не получилось, внимательно проверьте все поля на корректность ввода.');
				}
				if ($post['cbx']) {
					$catRes = JobCatRez::find()->where(['id_res' => $model->id])->asArray()->all();
					$count = count($catRes) + count($post['cbx']);
					if ($count <= 5) {
						foreach ($post['cbx'] as $item) {
							$arr[] = [$model->id, $item];
						}
						$db = Yii::$app->db;
						$db->createCommand()->batchInsert('job_cat_rez', ['id_res', 'id_cat'], $arr)->execute();
					} else {
						\Yii::$app->session->setFlash('danger', '<h3>Изменить категории не получилось.</h3> Выбранных категорий должно быть меньше пяти.');
					}
				}
				return $this->redirect(['update', 'id' => $model->id]);
			} else {
				return $this->render('create', [
					'model' => $model,
				]);
			}
		} else {
			\Yii::$app->session->setFlash('info', 'Для подачи резюме Вы должны зарегистрироваться как частное лицо.');
			return $this->redirect(Url::home());
		}
	}

	/**
	 * Updates an existing JobResume model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$user = Yii::$app->user->getIdentity();
		if (!$user['company']) {
			$user_id = $user['id'];
			$model = $this->findModel(['id' => $id, 'id_user' => $user_id]);
			$post = \Yii::$app->request->post();
			if ($model->load($post)) {
				$model->id_user = $user_id;
				if ($post['cbx']) {
					$catRes = JobCatRez::find()->where(['id_res' => $model->id])->asArray()->all();
					$count = count($catRes) + count($post['cbx']);
					if ($count <= 5) {
						foreach ($post['cbx'] as $item) {
							$arr[] = [$id, $item];
						}
						$db = Yii::$app->db;
						$db->createCommand()->batchInsert('job_cat_rez', ['id_res', 'id_cat'], $arr)->execute();
						$model->m_keyword = $this->genKeywords($post['cbx'], $post['JobResume']['description']);
					} else {
						\Yii::$app->session->setFlash('danger', '<h3>Изменить категории не получилось.</h3> Выбранных категорий должно быть меньше пяти.');
					}
				}
				$model->m_description = $this->genDescription($post['JobResume']['title'], $post['JobResume']['description']);
				if ($model->save()) {
					\Yii::$app->session->setFlash('success', 'Изменения успешно внесены.');
				} else {
					\Yii::$app->session->setFlash('danger', 'Внести изменения не получилось, внимательно проверьте все поля на корректность ввода.');
				}
				return $this->redirect(['update', 'id' => $model->id]);
			} else {
				$_cat = new JobCatRez;
				$cat = $_cat->listCategory($id);

				return $this->render('update', [
					'model' => $model,
					'cat' => $cat,
				]);
			}
		} else {
			\Yii::$app->session->setFlash('info', 'Для подачи резюме Вы должны зарегистрироваться как частное лицо.');
			return $this->redirect(Url::home());
		}
	}

	private function genKeywords($cbx, $data)
	{
		if (is_array($cbx) && count($cbx) > 0) {
			$cat = JobCategory::find()->select('name')->where(['id' => $cbx])->asArray()->all();
			foreach ($cat as $item) {
				$arr[] = $item['name'];
			}
			return SeoFunc::generateKeywords($arr, $data);
		} else {
			return false;
		}
	}

	private function genDescription($text, $data)
	{
		if ($text != '' || $data != '') {
			return SeoFunc::generateDescription($text, $data);
		} else {
			return false;
		}
	}

	public function actionCatDel()
	{
		$post = \Yii::$app->request->post();
		if ($post) {
			$list = JobCatRez::findOne($post['cat_id']);
			$list->delete();
		}
	}


	/**
	 * Deletes an existing JobResume model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$item = $this->findModel($id);
		$user = Yii::$app->user->identity;
		if ($user->id == $item->id_user) {
			CommonQuery::deleteItem($item);
		}
		return $this->redirect(['my-resume']);
	}

	/**
	 * Finds the JobResume model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return JobResume the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = JobResume::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
