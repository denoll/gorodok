<?php

namespace app\modules\adv\controllers;

use frontend\widgets\Html;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use common\models\banners\Banner;
use common\models\banners\BannerAdv;
use common\models\CommonQuery;
use common\models\banners\BannerItem;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\imagine\Image;
use Imagine\Image\Point;

class AdvertController extends Controller
{

	protected $width;
	protected $height;

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['my-ads','view','create','upload'],
				'rules' => [
					[
						'actions' => ['my-ads','view','create','upload'],
						'allow' => true,
						'roles' => ['@'],
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
	 * @return array
	 */
	public function actions()
	{


		return [
			'upload' => [
				'class' => 'denoll\filekit\actions\UploadAction',
				'fileStorage' => 'bannerStorage',
				'disableCsrf' => false,
				'responseFormat' => Response::FORMAT_JSON,
				'on beforeSave' => function($event){

				},
				'on afterSave' => function($event) {
					/* @var $file \League\Flysystem\File */
					$file = $event->file;
					$post = Yii::$app->request->post('BannerItem');
					$width = (int)$post['width'];
					$height = (int)$post['height'];
					$this->width = (!empty($width) && $width >= 900 && $width <= 900) ? $width : 600;
					$this->height = (!empty($height) && $height >= 900 && $height <= 900) ? $height : 600;
					$path = Url::to('@frt_dir/img/banners/'.$file->getPath());
					Image::thumbnail($path, $this->width, $this->height)
						->save($path, ['quality' => 70]);
				}
			],
		];
	}

	/**
	 * Lists my advertisement banner.
	 * @return mixed
	 */
	public function actionMyAds()
	{
		$user = Yii::$app->user->getIdentity();
		$query = BannerItem::find()->where(['id_user' => $user->getId()]);
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count()]);
		$model = $query->offset($pages->offset)
			->limit($pages->limit)
			->with('advert')
			->with('banner')
			->all();

		return $this->render('my-ads', [
			'user' => $user,
			'model' => $model,
			'pages' => $pages,
		]);
	}

	/**
	 * View my advertisement banner.
	 * @return mixed
	 */
	public function actionView($id)
	{
		$user = Yii::$app->user->getIdentity();
		$model = BannerItem::find()->where(['id'=>$id,'id_user' => $user->getId()])
			->with('user')
			->with('advert')
			->with('banner')
			->one();

		return $this->render('view', [
			'user' => $user,
			'model' => $model,
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
			if ($model->isNewRecord) {
				$model->click_count = 0;
				$model->max_click = 0;
				$model->status = BannerItem::STATUS_VERIFICATION;
				$model->id_user = Yii::$app->user->id;
				$model->size = 12;
				$model->start = date('Y-m-d H:i:s');
				$model->save();
				CommonQuery::sendCreateBannerEmail($model);
				return $this->redirect(['view', 'id' => $model->id]);
			}
		} else {
			return $this->render('create', [
				'model' => $model,
				'advert' => BannerAdv::find()->where(['status' => BannerAdv::STATUS_ACTIVE])->asArray()->all(),
				'blocks' => Banner::find()->where(['status' => Banner::STATUS_ACTIVE])->asArray()->all(),
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
		if(!Yii::$app->user->isGuest){
			$user = Yii::$app->user->getIdentity();
			$model = BannerItem::find()->where(['id'=>$id,'id_user' => $user->getId()])->one();
			if($model->delete()){
				CommonQuery::sendDeleteBannerEmail($model);
			}
			return $this->redirect(['my-ads']);
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
		$model = BannerAdv::getAdvForBanner($key,true);
		if($model){
			foreach ($model as $item)
			echo '<option>Выберите рекламную компанию...</option>';
			echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
		}
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
