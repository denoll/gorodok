<?php

namespace app\modules\afisha\controllers;

use common\models\afisha\AfishaSearchBack;
use Yii;
use yii\helpers\Json;
use yii\helpers\FileHelper;
use common\models\afisha\Afisha;
use app\modules\afisha\Module;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AfishaController implements the CRUD actions for Afisha model.
 */
class AfishaController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			/*'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['index', 'view', 'create', 'update', 'delete', 'change-status', 'change-on-main'],
						'allow' => true,
						'roles' => ['admin'],
					],
				],
			],*/
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	/**
	 * Lists all Afisha models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new AfishaSearchBack();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Lists all Afisha categories.
	 * @return mixed
	 */
	public function actionCategory()
	{
		return $this->render('category');
	}

	/**
	 * Displays a single Afisha model.
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
	 * Creates a new Afisha model.
	 * If creation is successful, the browser will be redirected to the 'view' afisha.
	 * @return mixed
	 */
	public function actionCreate()
	{
		return $this->actionUpdate(null);
	}

	/**
	 * Updates an existing Afisha model.
	 * If update is successful, the browser will be redirected to the 'view' afisha.
	 * @param string $id
	 * @return mixed
	 */
	public function actionUpdate($id = null)
	{
		if ($id === null) {
			$model = new Afisha();
		} else {
			$model = $this->findModel($id);
		}
		//$module = Yii::$app->getModule('afisha');

		if ($model->load(Yii::$app->request->post())) {

			$model->image = UploadedFile::getInstance($model, 'image'); //Миниатюра

			if ($model->save()) {
				Yii::$app->getCache('afisha_on_main')->flush();
				Yii::$app->getCache('afisha_sidebar')->flush();
				Yii::$app->session->setFlash('success', 'Статья успешно сохранена.');
				return $this->redirect(['update', 'id' => $model->id]);
			} else {
				Yii::$app->session->setFlash('danger', 'Статья не сохранена.');
				return $this->redirect(['update', 'id' => $model->id]);
			}
		} else {
			$module = Yii::$app->getModule('afisha');
			return $this->render($id === null ? 'create' : 'update', [
				'model' => $model,
				'module' => $module,
			]);
		}
	}

	/**
	 * Deletes an existing Afisha model.
	 * If deletion is successful, the browser will be redirected to the 'index' afisha.
	 * @param string $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		//delete images
		$model = $this->findModel($id);
		$id_afisha = $model->id;
		$dir = Yii::getAlias('@frt_dir/img/afisha/');
		if (is_dir($dir) && $model->thumbnail) {
			$images = FileHelper::findFiles($dir, [
				'only' => [
					$model->thumbnail,
					$model->images
				],
			]);
			for ($n = 0; $n != count($images); $n++) {
				@unlink($images[$n]);
			}
			//delete directory
			//rmdir($dir);
		}

		//delete row from database
		if ($this->findModel($id)->delete()) {
			Yii::$app->session->setFlash('success', 'Новость успешно удалена.');
		}
		return $this->redirect(['index']);
	}

	public function actionDelimg($id, $file)
	{
		$pathDir = Yii::getAlias('@frt_dir/img/afisha/') . $id;
		$fileImg = $pathDir . '/' . $file;
		if (is_dir($pathDir) && is_file($fileImg)) {
			unlink($fileImg);
		}
		Yii::$app->session->setFlash('success', 'Изображение успешно удалено.');
		return $this->redirect(['update', 'id' => $id]);
	}

	public function actionChangeStatus()
	{
		$id = Yii::$app->request->post('id');
		if (isset($id)) {
			$model = Afisha::findOne($id);
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

	public function actionChangeOnMain()
	{
		$id = Yii::$app->request->post('id');
		if (isset($id)) {
			$model = Afisha::findOne($id);
			if ($model->on_main == 1) {
				$model->on_main = 0;
			} else {
				$model->on_main = 1;
			}
			if ($model->save()) {
				$status = $model->on_main;
				echo $status;
			}
		}
	}

	/**
	 * Finds the Afisha model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return Afisha the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Afisha::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested afisha does not exist.');
		}
	}


}
