<?php

namespace app\modules\auto\controllers;

use common\models\auto\AutoImg;
use common\models\auto\AutoModels;
use common\models\auto\AutoModify;
use common\widgets\buttons\ControllerButton;
use Yii;
use yii\helpers\Url;
use common\models\auto\AutoItem;
use common\models\auto\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;

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
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete-item' => ['POST'],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'upload' => [
				'class' => 'denoll\filekit\actions\UploadAction',
				'fileStorage' => 'autoStorage',
				'disableCsrf' => true,
				//'deleteRoute' => 'delete-img',
				//'responseDeleteUrlParam' => Url::to('/auto/item/delete-img'),
				'responseFormat' => Response::FORMAT_JSON,
				'on afterSave' => function ($event) {
					/* @var $file \League\Flysystem\File */
					$file = $event->file;
					$path = Url::to('@frt_dir/img/auto/' . $file->getPath());
					Image::thumbnail($path, 600, 400)
						->save($path, ['quality' => 80]);
				}
			],
			'delete' => [
				'class' => 'denoll\filekit\actions\DeleteAction',
				'fileStorage' => 'autoStorage',
			],
			'error' => [
				'class' => 'yii\web\ErrorAction',
			]
		];
	}

	/**
	 * Lists all AutoItem models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new ItemSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		Url::remember();
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single AutoItem model.
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
	 * Creates a new AutoItem model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new AutoItem();
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return ControllerButton::widget([
				'action' => Yii::$app->request->post('action'),
				'save_url' => Url::previous(),
				'update_url' => '/auto/item/update',
				'id' => $model->id
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
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return ControllerButton::widget([
				'action' => Yii::$app->request->post('action'),
				'save_url' => Url::previous(),
				'update_url' => '/auto/item/update',
				'id' => $model->id
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
		$images = AutoImg::find()->where(['id_item'=>$id])->all();
		$path = Url::to('@frt_dir/img/auto/');
		if($images){
			foreach ($images as $item){
				$file = $path.$item->path;
				if(file_exists($file)){
					unlink($file);
				}
			}
		}
		$model->delete();
		return $this->redirect(['index']);
	}


	/**
	 * @param $id_brand
	 * @return null
	 */
	public function actionGetModel($id_brand)
	{
		$id_brand = (int)$id_brand;
		if (!$id_brand) echo '<option value="0">Выберите модель... </option>';
		/** @var AutoModels $model */
		$model = AutoModels::find()->where(['status' => AutoModels::STATUS_ACTIVE, 'brand_id' => $id_brand])->all();
		echo '<option value="0">Выберите модель... </option>';
		foreach ($model as $item) {
			echo '<option value="' . $item->id . '">' . $item->name . '</option>';
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
		if (($model = AutoItem::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
