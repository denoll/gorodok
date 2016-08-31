<?php

namespace app\modules\news\controllers;

use common\models\news\NewsSearchBack;
use Yii;
use yii\helpers\Json;
use yii\helpers\FileHelper;
use common\models\news\News;
use common\models\news\NewsSearch;
use app\modules\news\Module;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use vova07\imperavi\actions\GetAction as ImperaviGetAction;
use vova07\imperavi\actions\UploadAction as ImperaviUploadAction;
use yii\filters\AccessControl;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['index', 'view', 'create', 'update', 'delete', 'change-status', 'change-on-main', 'image-upload', 'images-get'],
						'allow' => true,
						'roles' => ['admin'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	/**
	 * Lists all News models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new NewsSearchBack();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		// validate if there is a editable input saved via AJAX
		if (Yii::$app->request->post('hasEditable')) {
			// instantiate your book model for saving
			$newsId = Yii::$app->request->post('editableKey');
			$model = News::findOne($newsId);

			// store a default json response as desired by editable
			$out = Json::encode(['output' => '', 'message' => '']);

			// fetch the first entry in posted data (there should
			// only be one entry anyway in this array for an
			// editable submission)
			// - $posted is the posted data for Book without any indexes
			// - $post is the converted array for single model validation
			$post = [];
			$posted = current($_POST['News']);
			$post['News'] = $posted;
			// load model like any single model validation
			if ($model->load($post)) {
				// can save model or do something before saving model
				$model->save();
				$output = '';
				if (isset($posted['publish'])) {
					$output = Yii::$app->formatter->asDate($model->publish);
				}
				if (isset($posted['unpublish'])) {
					$output = Yii::$app->formatter->asDate($model->unpublish);
				}
				$out = Json::encode(['output' => $output, 'message' => '']);
			}
			// return ajax json encoded response and exit
			echo $out;
			return;
		}

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Lists all News categories.
	 * @return mixed
	 */
	public function actionCategory()
	{
		return $this->render('category');
	}

	/**
	 * Displays a single News model.
	 * @param string $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new News model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		return $this->actionUpdate(null);
	}

	/**
	 * Updates an existing News model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionUpdate($id = null)
	{
		if ($id === null) {
			$model = new News();
		} else {
			$model = $this->findModel($id);
		}
		//$module = Yii::$app->getModule('news');

		if ($model->load(Yii::$app->request->post())) {

			$model->image = UploadedFile::getInstance($model, 'image'); //Миниатюра
			//$module->urlToImages = '@frt_url/images/widgets/'.$model->id.'/';
			//$module->pathToImages = '@frt_dir/images/widgets/'.$model->id.'/';

			if ($model->save()) {
				Yii::$app->getCache('news_on_main')->flush();
				Yii::$app->getCache('news_sidebar')->flush();
				Yii::$app->session->setFlash('success', 'Новость успешно сохранена.');
				return $this->redirect(['update', 'id' => $model->id]);
			} else {
				Yii::$app->session->setFlash('danger', 'Новость не сохранена.');
				return $this->redirect(['update', 'id' => $model->id]);
			}
		} else {
			$module = Yii::$app->getModule('news');
			return $this->render($id === null ? 'create' : 'update', [
				'model' => $model,
				'module' => $module,
			]);
		}
	}

	/**
	 * Deletes an existing News model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		//delete images
		$model = $this->findModel($id);
		$id_news = $model->id;
		$dir = Yii::getAlias('@frt_dir/img/news/');
		if(is_dir($dir) && !empty($model->thumbnail) && !empty($model->images)){
			$images = FileHelper::findFiles($dir, [
				'only' => [
					$model->thumbnail,
					$model->images
				],
			]);
			for ($n = 0; $n != count($images); $n++) {
				@unlink($images[$n]);
			}
			//delete directory
			//rmdir($dir);
		}

		//delete row from database
		if ($this->findModel($id)->delete()) {
			Yii::$app->session->setFlash('success', 'Новость успешно удалена.');
		}
		return $this->redirect(['index']);
	}

	public function actionDelimg($id, $file)
	{
		$pathDir = Yii::getAlias('@frt_dir/img/news/') . $id;
		$fileImg = $pathDir . '/' . $file;
		if (is_dir($pathDir) && is_file($fileImg)) {
			unlink($fileImg);
		}
		Yii::$app->session->setFlash('success', 'Изображение успешно удалено.');
		return $this->redirect(['update', 'id' => $id]);
	}

	public function actionChangeStatus()
	{
		$id = Yii::$app->request->post('id');
		if (isset($id)) {
			$model = News::findOne($id);
			if ($model->status == 1) {
				$model->status = 0;
			} else {
				$model->status = 1;
			}
			if ($model->save()) {
				$status = $model->status;
				echo $status;
			}
		}
	}

	public function actionChangeOnMain()
	{
		$id = Yii::$app->request->post('id');
		if (isset($id)) {
			$model = News::findOne($id);
			if ($model->on_main == 1) {
				$model->on_main = 0;
			} else {
				$model->on_main = 1;
			}
			if ($model->save()) {
				$status = $model->on_main;
				echo $status;
			}
		}
	}

	/**
	 * Finds the News model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return News the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = News::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}


}
