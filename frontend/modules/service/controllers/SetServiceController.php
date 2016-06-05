<?php

namespace app\modules\service\controllers;

use Yii;
use common\models\service\Service;
use common\models\service\ServiceCat;
use common\models\service\ServiceSearch;
use common\models\service\ServiceBuySearch;
use common\models\service\VService;
use common\models\service\VServiceBuy;
use common\models\users\User;
use common\models\users\UserAccount;
use yii\web\Controller;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\widgets\Arrays;
use yii\filters\AccessControl;
use yii\data\Pagination;
/**
 * ServiceController implements the CRUD actions for Service model.
 */
class SetServiceController extends Controller
{
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists all ServiceBuySearch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServiceBuySearch();
        $search = $searchModel->search(Yii::$app->request->queryParams);
        $this->delSession();
        if($search){
            $dataProvider = $search;
            return $this->render('index', [
                'items' => true,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->render('index', [
                'items' => false,
            ]);
        }
    }
    private function delSession(){
        $get = \Yii::$app->request->get();
        if((!$get['cat']&&!$get['ServiceSearch']['cat'])||(!$get['cat']&&!$get['ServiceBuySearch']['cat'])){
            $ses = Yii::$app->session;
            $ses->open();
            $ses->set('current_cat',null);
            $ses->set('parent_cat',null);
            $ses->set('cat_child',null);
            $ses->set('first_child',null);
            $ses->close();
        }
    }

    /**
     * Displays a single VServiceBuy model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = VServiceBuy::find()->where(['id'=>$id])->asArray()->one();
        ServiceCat::setSessionCategoryTree($model['alias']);
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
