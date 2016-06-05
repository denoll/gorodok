<?php

namespace app\modules\jobs\controllers;
use common\models\jobs\JobProfile;
use common\models\users\UserEdu;
use common\models\users\UserExp;
use yii\web\Controller;
use yii\filters\AccessControl;

class JobProfileController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','edu','edu-add','exp','exp-add'],
                'rules' => [
                    [
                        'actions' => ['index','edu','edu-add','exp','exp-add'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = JobProfile::findOne(\Yii::$app->user->identity->getId());
        if($model == false){
            $model = new JobProfile();
        }
        $post = \Yii::$app->request->post();
        if($model->load($post)) {
            if($model->isNewRecord){
                $model->id_user = \Yii::$app->user->identity->getId();
            }
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', 'Изменения успешно внесены.');
            } else {
                \Yii::$app->session->setFlash('danger', 'Внести изменения не получилось, внимательно проверьте все поля на корректность ввода.');
            }
        }
        return $this->render('index',[
            'model'=>$model,
        ]);
    }

    public function actionEdu()
    {
        $user_id = \Yii::$app->user->identity->getId();
        $model = UserEdu::find()->where(['id_user'=>$user_id])->all();
        if($model == false){
            $model = new UserEdu();
        }
        return $this->render('edu',[
            'model'=>$model,
        ]);
    }
    public function actionEduAdd($id = null)
    {
        $user_id = \Yii::$app->user->identity->getId();
        if($id === null){
            $model = new UserEdu();
        }else{
            $model = UserEdu::findOne(['id'=>$id]);
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
            return $this->redirect('edu');
        }
        return $this->renderAjax('edu-add',[
            'model'=>$model,
        ]);
    }

    public function actionExp()
    {
        $user_id = \Yii::$app->user->identity->getId();
        $model = UserExp::find()->where(['id_user'=>$user_id])->all();
        if($model == false){
            $model = new UserExp();
        }
        return $this->render('exp',[
            'model'=>$model,
        ]);
    }
    public function actionExpAdd($id = null)
    {
        $user_id = \Yii::$app->user->identity->getId();
        if($id === null){
            $model = new UserExp();
        }else{
            $model = UserExp::findOne(['id'=>$id]);
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
            return $this->redirect('exp');
        }
        return $this->renderAjax('exp-add',[
            'model'=>$model,
        ]);
    }
}
