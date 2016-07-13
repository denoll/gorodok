<?php

namespace app\modules\konkurs\controllers;

use common\models\CommonQuery;
use common\models\konkurs\Konkurs;
use common\models\users\User;
use Yii;
use common\models\konkurs\KonkursItem;
use common\models\konkurs\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;
use yii\imagine\Image;
use Imagine\Image\Point;
use common\widgets\buttons\ControllerButton;

/**
 * ItemController implements the CRUD actions for KonkursItem model.
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
				'fileStorage' => 'konkursItemStorage',
				'disableCsrf' => false,
				'responseFormat' => Response::FORMAT_JSON,
				'on afterSave' => function ($event) {
					/* @var $file \League\Flysystem\File */
					$file = $event->file;
					$post = Yii::$app->request->post('KonkursItem');
					$path = Url::to('@frt_dir/img/konkurs/' . $file->getPath());
					Image::thumbnail($path, (int)$post['width'], (int)$post['height'])
						->save($path, ['quality' => 80]);
				}
			],
		];
	}

	/**
	 * Lists all KonkursItem models.
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
	 * Displays a single KonkursItem model.
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
	 * Creates a new KonkursItem model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new KonkursItem();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return ControllerButton::widget([
				'action' => Yii::$app->request->post('action'),
				'save_url' => Url::previous(),
				'update_url' => '/konkurs/item/update',
				'id' => $model->id
			]);
		} else {
			return $this->render('create', [
				'model' => $model,
				'users' => User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all()
			]);
		}
	}

	/**
	 * Updates an existing KonkursItem model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$cur_status = $model->status;
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if ($cur_status != $model->status) {
				CommonQuery::sendUpdateKonkursItemEmail($model, Url::to('@frt_url/konkurses/my-items/' . $model->konkurs->slug));
			}
			return ControllerButton::widget([
				'action' => Yii::$app->request->post('action'),
				'save_url' => Url::previous(),
				'update_url' => '/konkurs/item/update',
				'id' => $model->id
			]);
		} else {
			return $this->render('update', [
				'model' => $model,
				'users' => User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all()
			]);
		}
	}

	/**
	 * @param string $id
	 */
	public function actionGetSize($id)
	{
		$model = Konkurs::findOne((int)$id);
		$arr = [
			'height' => $model->height,
			'width' => $model->width
		];
		echo json_encode($arr);
	}

	/**
	 * Deletes an existing KonkursItem model.
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
	 * Finds the KonkursItem model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return KonkursItem the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = KonkursItem::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
