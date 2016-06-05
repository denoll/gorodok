<?php
namespace app\modules\afisha\controllers;


use Yii;
use common\models\afisha\Afisha;
use common\models\afisha\AfishaSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * AfishaController implements actions for Afisha model.
 */
class AfishaController extends Controller
{
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
     * Lists all Afisha models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AfishaSearch();
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
        if(!$get['cat']&&!$get['AfishaSearch']['cat']){
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
     * Displays a single Afisha model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Afisha::find()->with('cat')->with('place')->where(['alias'=>$id])->asArray()->one();
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
