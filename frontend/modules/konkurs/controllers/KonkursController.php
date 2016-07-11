<?php

namespace app\modules\konkurs\controllers;

use common\models\konkurs\ItemSearchFront;
use common\models\konkurs\KonkursItem;
use common\models\konkurs\KonkursSearchFront;
use \common\models\konkurs\KonkursVote;
use Yii;
use common\models\konkurs\Konkurs;

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
		$post = Yii::$app->request->post();
		if (!Yii::$app->user->isGuest) {
			if ($post['rating'] !== null) {
				$vote = KonkursVote::find()->where(['id_konkurs' => $konkurs->id, 'id_item' => (int)$post['item'], 'id_user' => Yii::$app->user->id])->one();
				if (empty($vote)) {
					$vote = new KonkursVote();
					$vote->id_konkurs = $konkurs->id;
					$vote->id_item = (int)$post['item'];
					$vote->id_user = Yii::$app->user->id;
				}
				$vote->scope = (float)$post['rating'];
				if ($vote->save(false)) {
					echo
					KonkursItem::getSumScope((int)$post['item']);
					return $this->redirect(['view', 'id' => $id]);
				}
			}
		}
		Url::remember();
		return $this->render('view', [
			'model' => $konkurs,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Konkurs model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionMyItems($id)
	{
		if (!Yii::$app->user->isGuest) {
			$konkurs = $this->findModel($id);
			$searchModel = new ItemSearchFront();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $konkurs->id, false);
			Url::remember();
			return $this->render('my-items', [
				'model' => $konkurs,
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		} else {
			return $this->redirect(Url::previous());
		}
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
		$model = Konkurs::find()->with('cat')->where(['slug' => $slug])->one();
		if ($model) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
