<?php

namespace app\modules\page\controllers;

use Yii;
use yii\helpers\Json;
use yii\helpers\FileHelper;
use common\models\page\Page;
use common\models\page\PageSearch;
use app\modules\page\Module;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'change-status', 'change-on-main'],
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
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all Page categories.
     * @return mixed
     */
    public function actionCategory()
    {
        return $this->render('category');
    }

    /**
     * Displays a single Page model.
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
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->actionUpdate(null);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id = null)
    {
        if ($id === null) {
            $model = new Page();
        } else {
            $model = $this->findModel($id);
        }
        //$module = Yii::$app->getModule('page');

        if ($model->load(Yii::$app->request->post())) {

            $model->image = UploadedFile::getInstance($model, 'image'); //Миниатюра

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Статья успешно сохранена.');
                return $this->redirect(['update', 'id' => $model->id]);
            }else{
	            Yii::$app->session->setFlash('danger', 'Статья не сохранена.');
	            return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            $module = Yii::$app->getModule('page');
            return $this->render($id === null ? 'create' : 'update', [
                'model' => $model,
                'module' => $module,
            ]);
        }
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //delete images
        $model = $this->findModel($id);
        $id_page = $model->id;
        $dir = Yii::getAlias('@frt_dir/img/page/');
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
	        //delete directory
			//rmdir($dir);
	    }

        //delete row from database
        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Новость успешно удалена.');
        }
        return $this->redirect(['index']);
    }

    public function actionDelimg($id, $file){
        $pathDir = Yii::getAlias('@frt_dir/img/page/') . $id;
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
            $model = Page::findOne($id);
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
            $model = Page::findOne($id);
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
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
