<?php
namespace app\modules\page\controllers;


use Yii;
use common\models\page\Page;
use common\models\page\PageSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * PageController implements actions for Page model.
 */
class PageController extends Controller
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
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
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
        if(!$get['cat']&&!$get['PageSearch']['cat']){
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
     * Displays a single Page model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Page::find()->with('cat')->where(['alias'=>$id])->asArray()->one();
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
