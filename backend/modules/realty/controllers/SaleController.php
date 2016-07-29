<?php

namespace app\modules\realty\controllers;

use common\models\realty\RealtyCat;
use Yii;
use common\models\realty\RealtySale;
use app\modules\realty\models\SearchSale;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\widgets\buttons\ControllerButton;
use yii\web\Response;

/**
 * SaleController implements the CRUD actions for RealtySale model.
 */
class SaleController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'delete' => [ 'POST' ],
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
				'fileStorage' => 'realtySaleStorage',
				'disableCsrf' => true,
				'responseFormat' => Response::FORMAT_JSON,
				'on afterSave' => function ($event) {
					/* @var $file \League\Flysystem\File */
					$file = $event->file;
					$path = Url::to('@frt_dir/img/realty_sale/' . $file->getPath());
					Image::thumbnail($path, 600, 400)
						->save($path, ['quality' => 80]);
				}
			],
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	/**
	 * Lists all RealtySale models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new SearchSale();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		Url::remember();
		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single RealtySale model.
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
	 * Creates a new RealtySale model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new RealtySale();
		$post = Yii::$app->request->post();
		if ( $model->load($post)) {
			if(empty($post['RealtySale']['id_user'])){
				$model->id_user = Yii::$app->user->id;
			}
			$model->save();
			return ControllerButton::widget([
				'action' => Yii::$app->request->post('action'),
				'save_url' => Url::previous(),
				'update_url' => '/realty/sale/update',
				'id' => $model->id
			]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing RealtySale model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ( $model->load(Yii::$app->request->post()) && $model->save() ) {
			return ControllerButton::widget([
				'action' => Yii::$app->request->post('action'),
				'save_url' => Url::previous(),
				'update_url' => '/realty/sale/update',
				'id' => $model->id
			]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	public function actionChangeStatus()
	{
		$id = Yii::$app->request->post('id');
		if ( isset($id) ) {
			$model = RealtySale::findOne($id);
			if ( $model->status == 1 ) {
				$model->status = 0;
			} else {
				$model->status = 1;
			}
			if ( $model->save() ) {
				$status = $model->status;
				echo $status;
			}
		}
	}

	/**
	 * Проверка какие инпуты показывать в форме в зависимости от выбраной категории.
	 * @return mixed
	 */
	public function actionChangeElement()
	{
		$post = (integer)\Yii::$app->request->post('cat_id');
		if ($post) {
			$model = RealtyCat::findOne(['id' => $post]);
			$arr = [];
			if ($model->readonly == 1) {
				$arr['readonly'] = 'true';
			} else {
				$arr['readonly'] = 'false';
			}
			if ($model->area_home == 1) {
				$arr['area_home'] = 'show';
			} else {
				$arr['area_home'] = 'hide';
			}
			if ($model->area_land == 1) {
				$arr['area_land'] = 'show';
			} else {
				$arr['area_land'] = 'hide';
			}
			if ($model->floor == 1) {
				$arr['floor'] = 'show';
			} else {
				$arr['floor'] = 'hide';
			}
			if ($model->floor_home == 1) {
				$arr['floor_home'] = 'show';
			} else {
				$arr['floor_home'] = 'hide';
			}
			if ($model->comfort == 1) {
				$arr['comfort'] = 'show';
			} else {
				$arr['comfort'] = 'hide';
			}
			if ($model->repair == 1) {
				$arr['repair'] = 'show';
			} else {
				$arr['repair'] = 'hide';
			}
			if ($model->resell == 1) {
				$arr['resell'] = 'show';
			} else {
				$arr['resell'] = 'hide';
			}
			if ($model->type == 1) {
				$arr['type'] = 'show';
			} else {
				$arr['type'] = 'hide';
			}
			echo json_encode($arr);
		}
	}


	/**
	 * Deletes an existing RealtySale model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect([ 'index' ]);
	}

	/**
	 * Finds the RealtySale model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return RealtySale the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if ( ($model = RealtySale::findOne($id)) !== null ) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
