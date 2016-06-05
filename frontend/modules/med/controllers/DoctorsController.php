<?php

namespace app\modules\med\controllers;

use common\models\med\Service;
use common\models\med\VDoctors;
use common\models\User;
use common\models\users\UserEdu;
use common\models\users\UserExp;
use common\widgets\Arrays;
use Yii;
use common\models\med\Doctors;
use common\models\med\DoctorsSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DoctorController implements the CRUD actions for Doctors model.
 */
class DoctorsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['my-serv','serv-add','create','update','del-serv','delete'],
                'rules' => [
                    [
                        'actions' => ['my-serv','serv-add','create','update','del-serv','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'del-serv' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if($action->id == 'create'){
            Yii::$app->user->loginUrl = ['/site/simply-reg','v'=>1];
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Doctors models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DoctorsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Doctors model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = VDoctors::find()->where(['id_user'=>$id])->asArray()->one();
        //$service = Service::find()->where(['id_user'=>$id])->asArray()->all();
        $edu = UserEdu::find()->where(['id_user'=>$id])->asArray()->all();
        $exp = UserExp::find()->where(['id_user'=>$id])->asArray()->all();
        return $this->render('view', [
            'model' => $model,
            //'service' => $service,
            'edu'=>$edu,
            'exp'=>$exp,
        ]);
    }
    public function actionService($id)
    {
        $user = VDoctors::find()->where(['id_user'=>$id])->asArray()->one();
        $model = Service::find()->where(['id_user'=>$id])->asArray()->all();
        if($model == false){
            $model = new Service();
        }
        return $this->render('service',[
            'model'=>$model,
            'user'=>$user,
        ]);
    }
    public function actionMyServ()
    {
        $user_id = \Yii::$app->user->identity->getId();
        $model = Service::find()->where(['id_user'=>$user_id])->all();
        if($model == false){
            $model = new Service();
        }
        return $this->render('my-serv',[
            'model'=>$model,
        ]);
    }

    public function actionServAdd($id = null)
    {
        $user_id = \Yii::$app->user->identity->getId();
        if($id === null){
            $model = new Service();
        }else{
            $model = Service::findOne(['id'=>$id, 'id_user' => $user_id]);
        }
        $post = \Yii::$app->request->post();
        if($model->load($post)) {
            if($model->isNewRecord){
                $model->id_user = $user_id;
            }
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', 'Изменения успешно внесены.');
            } else {
                \Yii::$app->session->setFlash('danger', 'Внести изменения не получилось, внимательно проверьте все поля на корректность ввода.');
            }
            return $this->redirect('my-serv');
        }
        return $this->renderAjax('serv-add',[
            'model'=>$model,
        ]);
    }

    /**
     * Creates a new Doctors model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('info', '<h3 style="text-align: center; margin: 15px 0;">Для появления в каталоге врачей, пожалуйста, сначала пройдите регистрацию.</h3>');
            return $this->redirect([Url::home().'site/signup']);
        }else{
            $user = Yii::$app->user->getIdentity();
            $fio = $user->surname . ' ' . $user->name . ' ' . $user->patronym;
            $model = $this->findModel($user->getId());
            if (!$model) {
                $model = new Doctors();
                $post = Yii::$app->request->post();
                if ($model->load($post)) {
                    $m_user = User::findOne($user->getId());
                    $m_user->doctor = 1;
                    $model->id_user = $user->getId();
                    $spec = Arrays::getMedSpec($post['Doctors']['id_spec']);
                    $k_desc = ['Доктора в Тынде: ', $spec, $post['Doctors']['rank'], $fio, $post['Doctors']['about'], 'наша тында',];
                    $k_word = ['тында врачи','тында врач', $spec, $post['Doctors']['rank'], $post['Doctors']['about'], 'наша тында',];
                    $model->m_keyword = $this->keyword($k_word);
                    $model->m_description = $this->description($k_desc);
                    if ($model->save() && $m_user->save()) {
                        \Yii::$app->session->setFlash('success', 'Данные успешно сохранены и отправлены администрации на подтверждение.');
                    } else {
                        \Yii::$app->session->setFlash('danger', 'Данные не сохранены внимательно просмотрите все ли правильно Вы заполнили.');
                        return $this->redirect(['create', 'model' => $model]);
                    }
                    return $this->redirect(['update', 'id' => $model->id_user]);
                } else {
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            } else {
                \Yii::$app->session->setFlash('danger', 'Вы уже присутствуете в каталоге врачей.');
                return $this->redirect(['update']);
            }
        }

    }

    /**
     * Updates an existing Doctors model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        $user = Yii::$app->user->getIdentity();
        $fio = $user->surname . ' ' . $user->name . ' ' . $user->patronym;
        $model = $this->findModel($user->getId());
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $spec = Arrays::getMedSpec($post['Doctors']['id_spec']);
            $k_desc = ['Доктора в Тынде: ', $spec, $post['Doctors']['rank'], $fio, $post['Doctors']['about'], 'наша тында',];
            $k_word = ['тында врачи','тында врач', $spec, $post['Doctors']['rank'], $post['Doctors']['about'], 'наша тында',];
            $model->m_keyword = $this->keyword($k_word);
            $model->m_description = $this->description($k_desc);
            $model->save();
            return $this->redirect(['update', 'id' => $model->id_user]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Doctors model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        $user_id = Yii::$app->user->getId();
        $model = $this->findModel($user_id);
        Service::deleteAll(['id_user'=>$user_id]);
        $user = \common\models\users\User::findOne($user_id);
        $user->doctor = 0;
        $user->save();
        if($model->delete()){
            \Yii::$app->session->setFlash('success', 'Данные успешно удалены.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Doctors model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelServ($id)
    {
        $user = Yii::$app->user->getId();
        $model = Service::find()->where(['id'=>$id, 'id_user'=>$user])->one();
        if($model->delete()){
            \Yii::$app->session->setFlash('success', 'Данные успешно удалены.');
        }
        return $this->redirect(['my-serv']);
    }

    protected function keyword($array)
    {
        $str = implode(', ', $array);
        $str =  strip_tags($str);
        $str = substr($str, 0, 250);
        $str = trim($str);
        return $str;
    }
    protected function description($array)
    {
        $str = implode(' ', $array);
        $str =  strip_tags($str);
        $str = substr($str, 0, 250);
        $str = trim($str);
        return $str;
    }

    /**
     * Finds the Doctors model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Doctors the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Doctors::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
        }
    }
}
