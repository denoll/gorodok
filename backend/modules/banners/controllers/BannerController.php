<?php

namespace app\modules\banners\controllers;


use Yii;
use common\models\banners\Banner;
use common\models\banners\BannerItem;
use common\models\banners\BannerAdv;
use common\models\banners\BannerUsers;
use common\models\banners\BannerSearch;
use common\models\banners\ItemSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * TextController implements the CRUD actions for Text model.
 */
class BannerController extends Controller
{
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post']
				],
			],
		];
	}

	/**
	 * Lists all WidgetBanner models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new BannerSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		Url::remember(Url::current(),'banner');
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}


	/**
	 * Creates a new WidgetBanner model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Banner();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['update', 'id' => $model->key]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Banner model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$key = $id;
		$model = $this->findModel($key);

		$searchModel = new ItemSearch();
		$bannerItemsProvider = $searchModel->search([]);
		$bannerItemsProvider->query->andWhere(['banner_key' => $model->key]);
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(Url::previous('banner'));
		} else {
			return $this->render('update', [
				'model' => $model,
				'bannerItemsProvider' => $bannerItemsProvider,
				'banner_users' => BannerUsers::find()->where(['status' => 1])->asArray()->all(),
				'advert' => BannerAdv::find()->where(['status' => 1])->asArray()->all(),
			]);
		}
	}

	/**
	 * Deletes an existing WidgetBanner model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$key = $id;
		$this->findModel(['key' => $key])->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the WidgetBanner model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $key
	 * @return Banner the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($key)
	{
		if (($model = Banner::findOne(['key' => $key])) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
