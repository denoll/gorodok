<?php

namespace app\modules\banners\controllers;

use common\models\banners\Banner;
use common\models\banners\BannerAdv;
use common\models\CommonQuery;
use common\models\users\User;
use Yii;
use common\models\banners\BannerItem;
use common\models\banners\ItemSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\imagine\Image;
use Imagine\Image\Point;

/**
 * ItemController implements the CRUD actions for BannerItem model.
 */
class ItemController extends Controller
{
	protected $width;
	protected $height;

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

	public function actions()
	{
		return [
			'upload' => [
				'class' => 'denoll\filekit\actions\UploadAction',
				'fileStorage' => 'bannerStorage',
				'disableCsrf' => false,
				'responseFormat' => Response::FORMAT_JSON,
				'on afterSave' => function($event) {
					/* @var $file \League\Flysystem\File */
					$file = $event->file;
					$post = Yii::$app->request->post('BannerItem');
					$width = (int)$post['width'];
					$height = (int)$post['height'];
					$this->width = (!empty($width)) ? $width : 600;
					$this->height = (!empty($height)) ? $height : 600;
					$path = Url::to('@frt_dir/img/banners/'.$file->getPath());
					Image::thumbnail($path, $this->width,$this->height)
						->save($path, ['quality' => 80]);
				}
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
			'users' => User::find()->where(['status' => User::STATUS_ACTIVE, 'company' => 1])->asArray()->all(),
			'advert' => BannerAdv::find()->where(['status' => 1])->asArray()->all(),
			'blocks' => Banner::find()->asArray()->all(),
		]);
	}

	public function actionDelSession()
	{
		Yii::$app->session->remove('_uploadedFiles');
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
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
				'model' => $model,
				'users' => User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all(),
				'advert' => BannerAdv::find()->where(['status' => BannerAdv::STATUS_ACTIVE])->orWhere(['status' => BannerAdv::STATUS_ONLY_STAFF])->asArray()->all(),
				'blocks' => Banner::find()->where(['status' => Banner::STATUS_ACTIVE])->orWhere(['status' => Banner::STATUS_ONLY_STAFF])->asArray()->all(),
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
		$last_status = $model->status;
		if ($model->load(Yii::$app->request->post())) {
			$model->save();
			$new_status = $model->status;
			if($last_status !== $new_status){
				$link = Url::to('@frt_url/adv/advert/my-ads');
				CommonQuery::sendUpdateBannerEmail($model, $link);
			}
			return $this->redirect(Url::previous());
		} else {
			return $this->render('update', [
				'model' => $model,
				'users' => User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all(),
				'advert' => BannerAdv::find()->where(['status' => BannerAdv::STATUS_ACTIVE])->orWhere(['status' => BannerAdv::STATUS_ONLY_STAFF])->asArray()->all(),
				'blocks' => Banner::find()->where(['status' => Banner::STATUS_ACTIVE])->orWhere(['status' => Banner::STATUS_ONLY_STAFF])->asArray()->all(),
			]);
		}
	}

	/**
	 * @param string $key
	 */
	public function actionGetSize($key)
	{
		$model = BannerAdv::findOne($key);
		$arr = [
			'height' => $model->height,
			'width' => $model->width
		];
		echo json_encode($arr);
	}

	/**
	 * @param string $key
	 */
	public function actionGetAdv($key)
	{
		$model = BannerAdv::getAdvForBanner($key,false);
		if($model){
			foreach ($model as $item)
				echo '<option>Выберите рекламную компанию...</option>';
			echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
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
