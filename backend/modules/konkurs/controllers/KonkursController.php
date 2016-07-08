<?php

namespace app\modules\konkurs\controllers;

use common\widgets\buttons\ControllerButton;
use Yii;
use common\models\konkurs\Konkurs;
use common\models\konkurs\KonkursSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;
use yii\imagine\Image;
use Imagine\Image\Point;

/**
 * KonkursController implements the CRUD actions for Konkurs model.
 */
class KonkursController extends Controller
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
				'fileStorage' => 'konkursStorage',
				'disableCsrf' => false,
				'responseFormat' => Response::FORMAT_JSON,
				'on afterSave' => function ($event) {
					/* @var $file \League\Flysystem\File */
					$file = $event->file;
					$post = Yii::$app->request->post('Konkurs');
					$path = Url::to('@frt_dir/img/konkurs/main/' . $file->getPath());
					Image::thumbnail($path, (int)Konkurs::WIDTH_IMG, (int)Konkurs::HEIGHT_IMG)
						->save($path, ['quality' => 80]);
				}
			],
		];
	}

	/**
	 * Lists all Konkurs models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new KonkursSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		Url::remember();
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Konkurs model.
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
	 * Creates a new Konkurs model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Konkurs();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return ControllerButton::widget([
				'action' => Yii::$app->request->post('action'),
				'save_url' => Url::previous(),
				'update_url' => '/konkurs/konkurs/update',
				'id'=>$model->id
			]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Konkurs model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return ControllerButton::widget([
				'action' => Yii::$app->request->post('action'),
				'save_url' => Url::previous(),
				'update_url' => '/konkurs/konkurs/update',
				'id'=>$model->id
			]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Konkurs model.
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
	 * Finds the Konkurs model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Konkurs the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Konkurs::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
