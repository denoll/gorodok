<?php

namespace app\modules\firm\controllers;

use common\models\firm\FirmSearchFront;
use common\models\users\User;
use Yii;
use yii\helpers\Url;
use common\models\firm\Firm;
use common\models\firm\FirmSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\imagine\Image;
use Imagine\Image\Point;

/**
 * FirmController implements the CRUD actions for Firm model.
 */
class FirmController extends Controller
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
	 * @return array
	 */
	public function actions()
	{
		return [
			'upload' => [
				'class' => 'denoll\filekit\actions\UploadAction',
				'fileStorage' => 'firmStorage',
				'disableCsrf' => false,
				'responseFormat' => Response::FORMAT_JSON,
				'on afterSave' => function ($event) {
					/* @var $file \League\Flysystem\File */
					$file = $event->file;
					$path = Url::to('@frt_dir/img/logo/' . $file->getPath());
					Image::thumbnail($path, Firm::WIDTH, Firm::HEIGHT)
						->save($path, ['quality' => 80]);
				}
			],
		];
	}

	/**
	 * Lists all Firm models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new FirmSearchFront();
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
	 * Displays a single Firm model.
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
	 * Creates a new Firm model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		return $this->actionUpdate();
	}
	/**
	 * Updates an existing Firm model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionUpdate()
	{
		if(Yii::$app->user->isGuest){
			Yii::$app->session->setFlash('info',[
				'<h3>С начала пройдите простую процедуру регистрации.</h3><p><strong style="color: darkred;">Внимание! <br>Вам необходимо зарегистрироваться как компания!"</strong></p>'
			]);
			return $this->redirect(['/site/signup']);
		}
		$user = Yii::$app->user->getIdentity();
		if(!$user->company){
			Yii::$app->session->setFlash('info',[
				'<h3>Вы должны быть зарегистрированы как компания.</h3>'
			]);
			return $this->redirect(Url::previous());
		}
		$model = Firm::findOne(['id_user'=>$user->id]);
		if(!$model){
			$model = new Firm();
			$model->id_user = Yii::$app->user->id;
		}
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if(empty($user->company_name)){
				$m_user = User::findOne($user->id);
				$m_user->company_name = $model->name;
			}
			return $this->redirect(['index']);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}

	}

	/**
	 * Finds the Firm model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Firm the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		$model = Firm::find()->where(['id'=>$id, 'status' => Firm::STATUS_ACTIVE, 'show_requisites' => Firm::STATUS_ACTIVE])->with('cat')->one();
		if ($model !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
