<?php

namespace app\modules\service\controllers;

use Yii;
use common\models\service\Service;
use app\modules\service\models\ServiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class ServiceController extends Controller
{
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
	 * Lists all Goods models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new ServiceSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionChangeStatus()
	{
		$id = Yii::$app->request->post('id');
		if (isset($id)) {
			$model = Service::findOne($id);
			if ($model->status == 1) {
				$model->status = 0;
			} else {
				$model->status = 1;
			}
			if ($model->save()) {
				$status = $model->status;
				echo $status;
			}
		}
	}

	/**
	 * Displays a single Goods model.
	 * @param string $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Service model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Service();
		if ($model->load(Yii::$app->request->post())) {
			$model->image = \yii\web\UploadedFile::getInstance($model, 'image');
			if ($model->save()) {
				\Yii::$app->session->setFlash('success', 'Объявление успешно сохранено.');
			} else {
				\Yii::$app->session->setFlash('danger', 'По каким-то причинам сохранить объявление не удалось.<br>Пожалуйста повторите попытку.');
			}
			return $this->redirect(['index']);
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
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post())) {
			$model->image = \yii\web\UploadedFile::getInstance($model, 'image');
			if ($model->save()) {
				\Yii::$app->session->setFlash('success', 'Изменения успешно внесены.');
			} else {
				\Yii::$app->session->setFlash('danger', 'По каким-то причинам сохранить изменения не удалось.<br>Пожалуйста повторите попытку.');
			}
			return $this->redirect(['index']);
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
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Service model based on its primary key value.
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
