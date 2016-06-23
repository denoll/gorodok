<?php

namespace app\modules\slider\controllers;

use common\models\slider\SliderSearch;
use Yii;
use common\models\slider\SliderMain;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * SliderController implements the CRUD actions for SliderMain model.
 */
class SliderController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['index', 'view', 'create', 'update', 'delete', 'change-status'],
						'allow' => true,
						'roles' => ['admin'],
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

	/**
	 * Lists all SliderMain models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new SliderSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionChangeStatus()
	{
		$id = Yii::$app->request->post('id');
		if (!empty($id)) {
			$status = SliderMain::changeStatus($id);
			echo $status;
		}
	}

	/**
	 * Creates a new SliderMain model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		return $this->actionUpdate(null);
	}

	/**
	 * Updates an existing SliderMain model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		if ($id === null) {
			$model = new SliderMain();
		} else {
			$model = $this->findModel($id);
		}
		if ($model->load(Yii::$app->request->post())) {
			$model->image = \yii\web\UploadedFile::getInstance($model, 'image'); //Миниатюра
			if ($model->save()) {
				Yii::$app->session->setFlash('success', 'Фото успешно сохранено.');
				return $this->redirect(['update', 'id' => $model->id]);
			} else {
				Yii::$app->session->setFlash('danger', 'Фото не сохранено.');
				return $this->redirect(['update', 'id' => $model->id]);
			}
		} else {
			$module = Yii::$app->getModule('slider');
			return $this->render($id === null ? 'create' : 'update', [
				'model' => $model,
				'module' => $module,
			]);
		}
	}

	/**
	 * Deletes an existing SliderMain model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		//delete images
		$images = FileHelper::findFiles(Yii::getAlias('@frt_dir/img/slider/'), [
			'only' => [
				$model->id_user . '_' . $model->id . '.*',
				'thumb_' . $model->id_user . '_' . $model->id . '.*',
			],
		]);
		for ($i = 0; $i != count($images); $i++) {
			@unlink($images[$i]);
		}
		$model->delete();
		return $this->redirect(['index']);
	}

	/**
	 * Finds the SliderMain model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return SliderMain the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = SliderMain::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
