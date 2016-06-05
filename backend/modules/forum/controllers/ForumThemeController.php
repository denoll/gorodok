<?php

	namespace app\modules\forum\controllers;

	use Yii;
	use common\models\forum\ForumTheme;
	use common\models\forum\ForumThemeSearch;
	use common\models\forum\ForumMessage;
	use common\models\forum\ForumMessageSearch;
	use common\models\users\User;
	use yii\web\Controller;
	use yii\web\NotFoundHttpException;
	use yii\filters\VerbFilter;
	use yii\filters\AccessControl;

	/**
	 * ForumThemeController implements the CRUD actions for ForumTheme model.
	 */
	class ForumThemeController extends Controller
	{
		public function behaviors()
		{
			return [
				'access' => [
					'class' => AccessControl::className(),
					'rules' => [
						[
							'actions' => ['index', 'view', 'create', 'update', 'delete', 'message', 'create-message', 'update-message', 'delete-message'],
							'allow' => true,
							'roles' => ['admin'],
						],
					],
				],
				'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'delete' => ['post'],
						'delete-message' => ['post'],
					],
				],
			];
		}

		/**
		 * Lists all ForumTheme models.
		 * @return mixed
		 */
		public function actionIndex()
		{
			$searchModel = new ForumThemeSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		}

		/**
		 * Displays a single ForumTheme model.
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
		 * Creates a new ForumTheme model.
		 * If creation is successful, the browser will be redirected to the 'view' page.
		 * @return mixed
		 */
		public function actionCreate()
		{
			$model = new ForumTheme();

			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				$user_id = Yii::$app->user->identity->getId();
				$user = User::findOne($user_id);
				$f_theme_count = ForumTheme::find()->where(['id_author'=>$user_id, 'status'=>1])->count();
				$user->count_ft = $f_theme_count;
				$user->save();
				return $this->redirect(['index']);
			} else {
				return $this->render('create', [
					'model' => $model,
				]);
			}
		}

		/**
		 * Updates an existing ForumTheme model.
		 * If update is successful, the browser will be redirected to the 'view' page.
		 * @param string $id
		 * @return mixed
		 */
		public function actionUpdate($id)
		{
			$model = $this->findModel($id);

			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['index']);
			} else {
				return $this->render('update', [
					'model' => $model,
				]);
			}
		}

		/**
		 * Deletes an existing ForumTheme model.
		 * If deletion is successful, the browser will be redirected to the 'index' page.
		 * @param string $id
		 * @return mixed
		 */
		public function actionDelete($id)
		{
			$user_id = Yii::$app->user->identity->getId();
			$user = User::findOne($user_id);
			$f_theme_count = ForumTheme::find()->where(['id_author'=>$user_id, 'status'=>1])->count();
			$user->count_ft = $f_theme_count;
			$user->save();
			$this->findModel($id)->delete();
			return $this->redirect(['index']);
		}


		public function actionMessage($id)
		{
			$session = Yii::$app->session;
			$session->open();
			$session->set('forum_theme_id',$id);
			$session->close();
			$searchModel =  new ForumMessageSearch();
			$params = Yii::$app->request->queryParams;
			$dataProvider = $searchModel->search($params, $id);
			$theme = ForumTheme::findOne($id);
			return $this->render('message', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'theme'=>$theme,
			]);
		}

		/**
		 * Creates a new ForumMessage model.
		 * If creation is successful, the browser will be redirected to the 'view' page.
		 * @param string $id
		 * @return mixed
		 */
		public function actionCreateMessage()
		{
			$session = Yii::$app->session;
			$session->open();
			$theme_id = $session->get('forum_theme_id');
			$session->close();
			$model = new ForumMessage();
			$theme = ForumTheme::findOne(['id'=>$theme_id]);

			if ($model->load(Yii::$app->request->post()) ) {
				$user_id = Yii::$app->user->identity->getId();
				$model->id_cat = $theme->id_cat;
				$model->id_theme = $theme_id;
				$model->id_author = $user_id;
				$user = User::findOne($user_id);
				$f_message_count = ForumTheme::find()->where(['id_author'=>$user_id, 'status'=>1])->count();
				$user->count_fm = $f_message_count;
				$user->save();
				$model->save();
				return $this->redirect(['message', 'id' => $theme_id]);
			} else {
				return $this->render('create-message', [
					'model' => $model,
					'theme' => $theme,
				]);
			}
		}

		/**
		 * Updates an existing ForumMessage model.
		 * If update is successful, the browser will be redirected to the 'view' page.
		 * @param string $id
		 * @param string $theme_id
		 * @return mixed
		 */
		public function actionUpdateMessage($id, $theme_id)
		{
			$model = $this->findModelMessage($id);
			$theme = ForumTheme::findOne(['id'=>$theme_id]);

			if ($model->load(Yii::$app->request->post())) {

				$model->save();
				return $this->redirect(['message', 'id' => $theme_id]);
			} else {
				return $this->render('update-message', [
					'model' => $model,
					'theme' => $theme,
				]);
			}
		}

		/**
		 * Deletes an existing ForumMessage model.
		 * If deletion is successful, the browser will be redirected to the 'index' page.
		 * @param int $id
		 * @param int $theme_id
		 * @param int $author_id
		 * @return mixed
		 */
		public function actionDeleteMessage($id, $theme_id, $author_id)
		{
			$user = User::findOne($author_id);
			$f_message_count = ForumTheme::find()->where(['id_author'=>$author_id, 'status'=>1])->count();
			$user->count_fm = $f_message_count;
			$user->save();
			$this->findModelMessage($id)->delete();
			return $this->redirect(['message', 'id' => $theme_id]);
		}

		/**
		 * Finds the ForumMessage model based on its primary key value.
		 * If the model is not found, a 404 HTTP exception will be thrown.
		 * @param string $id
		 * @return ForumMessage the loaded model
		 * @throws NotFoundHttpException if the model cannot be found
		 */
		protected function findModelMessage($id)
		{
			if (($model = ForumMessage::findOne($id)) !== null) {
				return $model;
			} else {
				throw new NotFoundHttpException('The requested page does not exist.');
			}
		}

		/**
		 * Finds the ForumTheme model based on its primary key value.
		 * If the model is not found, a 404 HTTP exception will be thrown.
		 * @param string $id
		 * @return ForumTheme the loaded model
		 * @throws NotFoundHttpException if the model cannot be found
		 */
		protected function findModel($id)
		{
			if (($model = ForumTheme::findOne($id)) !== null) {
				return $model;
			} else {
				throw new NotFoundHttpException('The requested page does not exist.');
			}
		}
	}
