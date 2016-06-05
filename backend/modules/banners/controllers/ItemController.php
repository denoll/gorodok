<?php

namespace app\modules\banners\controllers;

use common\models\banners\Banner;
use common\models\banners\BannerAdv;
use common\models\users\User;
use Yii;
use common\models\banners\BannerItem;
use common\models\banners\ItemSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ItemController implements the CRUD actions for BannerItem model.
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
	 * Lists all BannerItem models.
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
			'users' => User::find()->where(['status' => User::STATUS_ACTIVE, 'company'=>1])->asArray()->all(),
			'advert' => BannerAdv::find()->where(['status' => 1])->asArray()->all(),
			'blocks' => Banner::find()->where(['status' => 1])->asArray()->all(),
		]);
	}

	/**
	 * Displays a single BannerItem model.
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
	 * Creates a new BannerItem model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new BannerItem();
		if ($model->load(Yii::$app->request->post())) {
			$model->bannerImage = UploadedFile::getInstance($model, 'bannerImage');
			if(null !== $img_name = $model->upload()){
				$model->path = $img_name;
			}
			$model->save();
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
				'model' => $model,
				'users' => User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all(),
				'advert' => BannerAdv::find()->where(['status' => 1])->asArray()->all(),
				'blocks' => Banner::find()->where(['status' => 1])->asArray()->all(),
			]);
		}
	}

	/**
	 * Updates an existing BannerItem model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())){
			$model->bannerImage = UploadedFile::getInstance($model, 'bannerImage');
			if(null !== $img_name = $model->upload()){
				$model->path = $img_name;
			}
			$model->save();
			return $this->redirect(Url::previous());
		} else {
			return $this->render('update', [
				'model' => $model,
				'users' => User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all(),
				'advert' => BannerAdv::find()->where(['status' => 1])->asArray()->all(),
				'blocks' => Banner::find()->where(['status' => 1])->asArray()->all(),
			]);
		}
	}

	/**
	 * Deletes an existing BannerItem model.
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
	 * Finds the BannerItem model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return BannerItem the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = BannerItem::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
