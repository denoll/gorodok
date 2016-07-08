<?php

namespace app\modules\konkurs\controllers;

use common\models\konkurs\ItemSearchFront;
use common\models\konkurs\KonkursSearchFront;
use common\widgets\buttons\ControllerButton;
use Yii;
use common\models\konkurs\Konkurs;
use common\models\konkurs\KonkursSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;
use yii\imagine\Image;
use Imagine\Image\Point;

/**
 * KonkursController implements the CRUD actions for Konkurs model.
 */
class KonkursController extends Controller
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
	 * Lists all Konkurs models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new KonkursSearchFront();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		Url::remember();
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Konkurs model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$konkurs = $this->findModel($id);
		$searchModel = new ItemSearchFront();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $konkurs->id);
		return $this->render('view', [
			'model' => $konkurs,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Finds the Konkurs model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $slug
	 * @return Konkurs the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($slug)
	{
		if (($model = Konkurs::findOne(['slug'=>$slug])) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
