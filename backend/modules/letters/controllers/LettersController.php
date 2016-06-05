<?php

namespace app\modules\letters\controllers;

use common\models\letters\LettersComments;
use common\models\letters\LettersCommentsSearch;
use Yii;
use yii\helpers\Json;
use yii\helpers\FileHelper;
use common\models\letters\Letters;
use common\models\letters\LettersSearchBack;
use app\modules\letters\Module;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use vova07\imperavi\actions\GetAction as ImperaviGetAction;
use vova07\imperavi\actions\UploadAction as ImperaviUploadAction;
use yii\filters\AccessControl;

/**
 * LettersController implements the CRUD actions for Letters model.
 */
class LettersController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'comments', 'update-comment', 'create-comment', 'delete-comment', 'change-comment-status', 'change-status', 'change-on-main','image-upload','images-get'],
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
     * @inheritdoc
     */
    public function actions()
    {
        $module = Yii::$app->getModule('letters');

        $actions = [];
        return $actions;
    }

    /**
     * Lists all Letters models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LettersSearchBack();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all Letters categories.
     * @return mixed
     */
    public function actionCategory()
    {
        return $this->render('category');
    }

    /**
     * Displays a single Letters model.
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
     * Creates a new Letters model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->actionUpdate(null);
    }

    /**
     * Updates an existing Letters model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id = null)
    {
        if ($id === null) {
            $model = new Letters();
        } else {
            $model = $this->findModel($id);
        }
        if ($model->load(Yii::$app->request->post())) {

            $model->image = UploadedFile::getInstance($model, 'image'); //Миниатюра
            if($model->isNewRecord){
                $model->id_user = Yii::$app->user->identity->getId();
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Письмо успешно сохранено.');
                return $this->redirect(['update', 'id' => $model->id]);
            }else{
	            Yii::$app->session->setFlash('danger', 'Письмо не сохранено.');
	            return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            $module = Yii::$app->getModule('letters');
            return $this->render($id === null ? 'create' : 'update', [
                'model' => $model,
                'module' => $module,
            ]);
        }
    }

    public function actionComments($id)
    {
        $searchModel = new LettersCommentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('comments', [
            'letter_id'=>$id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateComment($letter)
    {
        return $this->actionUpdateComment(null,$letter);
    }

    public function actionUpdateComment($id, $letter = null)
    {
        if ($id === null && $letter != null) {
            $model = new LettersComments();
        } else {
            $model = LettersComments::findOne($id);
        }
        if ($model->load(Yii::$app->request->post())) {

            if($model->isNewRecord && $letter != null){
                $model->id_user = Yii::$app->user->identity->getId();
                $model->id_letter = $letter;
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Комментарий успешно сохранен.');
                return $this->redirect(['comments', 'id' => $model->id_letter]);
            }else{
                Yii::$app->session->setFlash('danger', 'Комментарий не сохранен.');
                return $this->redirect(['comments', 'id' => $model->id_letter]);
            }
        } else {
            return $this->renderAjax($id === null ? 'create-comment' : 'update-comment', [
                'model' => $model,
            ]);
        }
    }

    public function actionDeleteComment($id)
    {
        $comment = LettersComments::findOne($id);
        $id_letter = $comment->id_letter;
        if($comment->delete()){
            Yii::$app->session->setFlash('success', 'Комментарий успешно удален.');
        }
        return $this->redirect(['comments','id'=>$id_letter]);
    }

    public function actionChangeCommentStatus(){
        $id = Yii::$app->request->post('id');
        if(isset($id)) {
            $model = LettersComments::findOne($id);
            if($model->status == 1){
                $model->status = 0;
            }else{
                $model->status = 1;
            }
            if($model->save()){
                $status = $model->status;
                echo $status;
            }
        }
    }


    /**
     * Deletes an existing Letters model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //delete images
        $model = $this->findModel($id);
        $dir = Yii::getAlias('@frt_dir/img/letters/');
	    if(is_dir($dir)){
	        $images = FileHelper::findFiles($dir, [
	            'only' => [
	                $model->thumbnail,
                    $model->images
	            ],
	        ]);
	        for ($n = 0; $n != count($images); $n++) {
	            @unlink($images[$n]);
	        }
	    }
        //delete row from database
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Письмо успешно удалено.');
        }
        return $this->redirect(['index']);
    }

    public function actionDelimg($id, $file){
        $pathDir = Yii::getAlias('@frt_dir/img/letters/') . $id;
        $fileImg = $pathDir . '/' . $file;
        if(is_dir($pathDir)&& is_file($fileImg)){
            unlink($fileImg);
        }
        Yii::$app->session->setFlash('success', 'Изображение успешно удалено.');
        return $this->redirect(['update', 'id' => $id]);
    }

    public function actionChangeStatus(){
        $id = Yii::$app->request->post('id');
        if(isset($id)) {
            $model = Letters::findOne($id);
            if($model->status == 1){
                $model->status = 0;
            }else{
                $model->status = 1;
            }
            if($model->save()){
                $status = $model->status;
                echo $status;
            }
        }
    }
    public function actionChangeOnMain(){
        $id = Yii::$app->request->post('id');
        if(isset($id)) {
            $model = Letters::findOne($id);
            if($model->on_main == 1){
                $model->on_main = 0;
            }else{
                $model->on_main = 1;
            }
            if($model->save()){
                $status = $model->on_main;
                echo $status;
            }
        }
    }

    /**
     * Finds the Letters model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Letters the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Letters::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
