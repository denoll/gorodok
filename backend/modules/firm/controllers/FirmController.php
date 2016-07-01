<?php

namespace app\modules\firm\controllers;

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
		$searchModel = new FirmSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
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
		$model = new Firm();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['update', 'id' => $model->id]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Firm model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index']);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Firm model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
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
		if (($model = Firm::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
