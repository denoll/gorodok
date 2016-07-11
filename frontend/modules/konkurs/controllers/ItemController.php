<?php

namespace app\modules\konkurs\controllers;

use common\models\konkurs\KonkursVote;
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
					$post = Yii::$app->request->post('KonkursItem');
					$width = (int)$post['width'];
					$height = (int)$post['height'];
					$this->width = (!empty($width) && $width >= 300 && $width <= 800) ? $width : 600;
					$this->height = (!empty($height) && $height >= 300 && $height <= 800) ? $height : 400;
					$file = $event->file;
					$path = Url::to('@frt_dir/img/konkurs/' . $file->getPath());
					Image::thumbnail($path, $this->width, $this->height)
						->save($path, ['quality' => 80]);
				}
			],
		];
	}


	/**
	 * Displays a single KonkursItem model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionItem($id)
	{
		$model = $this->findModel($id);
		$post = Yii::$app->request->post();
		if (!Yii::$app->user->isGuest) {
			if ($post['rating'] !== null) {
				$vote = KonkursVote::find()->where(['id_konkurs' => $model->konkurs->id, 'id_item' => (int)$post['item'], 'id_user' => Yii::$app->user->id])->one();
				if (empty($vote)) {
					$vote = new KonkursVote();
					$vote->id_konkurs = $model->konkurs->id;
					$vote->id_item = (int)$post['item'];
					$vote->id_user = Yii::$app->user->id;
				}
				$vote->scope = (float)$post['rating'];
				if ($vote->save(false)) {
					echo
					KonkursItem::getSumScope((int)$post['item']);
					return $this->redirect(['item', 'id' => $id]);
				}
			}
		} else {
			Url::remember();
		}
		return $this->render('item', [
			'model' => $model,
		]);
	}

	/**
	 * Creates a new KonkursItem model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$id_konkurs = Yii::$app->session->get('id_konkurs');
		if(empty($id_konkurs)||Yii::$app->user->isGuest){
			Url::remember();
			Yii::$app->session->setFlash('info','<h2>Для участия в конкурсе Вам необходимо войти на сайт или зарегистрироваться на сайте, если еще не регистрировались.</h2>');
			return $this->redirect(['/site/login']);
		}
		$model = new KonkursItem();
		if ($model->load(Yii::$app->request->post())) {
			$model->id_konkurs = Yii::$app->session->get('id_konkurs');
			$model->id_user = Yii::$app->user->id;
			$model->status = KonkursItem::STATUS_VERIFICATION;
			$model->save();
			return ControllerButton::widget([
				'action' => Yii::$app->request->post('action'),
				'save_url' => Url::previous(),
				'update_url' => '/konkurs/item/update',
				'id'=>$model->id
			]);
		} else {
			return $this->render('create', [
				'model' => $model,
				'users' => User::find()->where(['status'=>User::STATUS_ACTIVE])->asArray()->all(),
				'konkurs' => Konkurs::findOne($id_konkurs),
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
		$id_konkurs = Yii::$app->session->get('id_konkurs');
		if(empty($id_konkurs)||Yii::$app->user->isGuest){
			Url::remember();
			Yii::$app->session->setFlash('info','<h2>Для участия в конкурсе Вам необходимо войти на сайт или зарегистрироваться на сайте, если еще не регистрировались.</h2>');
			return $this->redirect(['/site/login']);
		}
		$model = $this->findModel($id);
		if($model->status !== KonkursItem::STATUS_VERIFICATION){
			Yii::$app->session->setFlash('danger','<h2>Вы не можете редактировать элменты которые были проверены администрацией сайта и опубликованы.</h2>');
			return $this->redirect(Url::previous());
		}

		if ($model->load(Yii::$app->request->post())) {
			$model->save();
			return ControllerButton::widget([
				'action' => Yii::$app->request->post('action'),
				'save_url' => Url::previous(),
				'update_url' => '/konkurs/item/update',
				'id'=>$model->id
			]);
		} else {
			return $this->render('update', [
				'model' => $model,
				'users' => User::find()->where(['status'=>User::STATUS_ACTIVE])->asArray()->all(),
				'konkurs' => Konkurs::findOne($id_konkurs),
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
