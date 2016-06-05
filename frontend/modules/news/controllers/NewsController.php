<?php
namespace app\modules\news\controllers;


use Yii;
use common\models\news\News;
use common\models\news\NewsSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * NewsController implements actions for News model.
 */
class NewsController extends Controller
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
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
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
        if(!$get['cat']&&!$get['NewsSearch']['cat']){
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
     * Displays a single News model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = News::find()->with('cat')->where(['alias'=>$id])->asArray()->one();
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
