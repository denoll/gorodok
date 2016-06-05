<?php

namespace app\modules\banners\controllers;

use common\models\banners\BannerItem;
use Yii;
use common\models\banners\BannerUsers;
use common\models\banners\BannerAdv;
use common\models\banners\BannerUserAccount;
use common\models\banners\AccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccountController implements the CRUD actions for BannerUserAccount model.
 */
class AccountController extends Controller
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
     * Lists all BannerUserAccount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountSearch();
        $dataProvider = $searchModel;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BannerUserAccount model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BannerUserAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BannerUserAccount();
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $model->invoice = 'ADV-'.$post['BannerUserAccount']['id_user'].'-'.time();
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'banner_users' => BannerUsers::find()->where(['status' => 1])->asArray()->all(),
                'advert' => BannerAdv::find()->where(['status' => 1])->asArray()->all(),
                'banner_items' => BannerItem::find()->where(['status' => 1])->asArray()->all(),
            ]);
        }
    }

    /**
     * Updates an existing BannerUserAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'banner_users' => BannerUsers::find()->where(['status' => 1])->asArray()->all(),
                'advert' => BannerAdv::find()->where(['status' => 1])->asArray()->all(),
                'banner_items' => BannerItem::find()->where(['status' => 1])->asArray()->all(),
            ]);
        }
    }

    /**
     * Deletes an existing BannerUserAccount model.
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
     * Finds the BannerUserAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BannerUserAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BannerUserAccount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
