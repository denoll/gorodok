<?php
namespace app\modules\letters\controllers;


use common\models\letters\LettersComments;
use common\models\letters\LettersRating;
use Yii;
use common\models\letters\Letters;
use common\models\letters\LettersSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\data\Pagination;
/**
 * LettersController implements actions for Letters model.
 */
class LettersController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['my-letters','update','create','create-comment','rating-up','rating-down'],
                'rules' => [
                    [
                        'actions' => ['my-letters','update','create','create-comment','rating-up','rating-down'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        if($action->id == 'create'){
            Yii::$app->user->loginUrl = ['/site/simply-reg','v'=>4];
        }
        return parent::beforeAction($action);
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Lists all Letters models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LettersSearch();
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
        if(!$get['cat']&&!$get['LettersSearch']['cat']){
            $ses = Yii::$app->session;
            $ses->open();
            $ses->set('current_cat',null);
            $ses->set('parent_cat',null);
            $ses->set('cat_child',null);
            $ses->set('first_child',null);
            $ses->close();
        }
    }

    public function actionRatingUp(){
        if(Yii::$app->user->isGuest)\Yii::$app->session->setFlash('danger', 'Для голосования зарегистрируйтесь или войдите на сайт.');
        $post = \Yii::$app->request->post();
        $rating = LettersRating::findOne([
            'id_user'=>Yii::$app->user->id,
            'id_letter'=>$post['letter_id']
        ]);
        if($rating->vote_yes === 1 ){
            $letter = Letters::findOne($post['letter_id']);
            $arr = [
                'rating' => $letter->rating,
                'vote_yes' => 'no',
                'vote_no' => 'no',
                'message' => 'yes',
            ];
            echo json_encode($arr);
        }else{
            if(empty($rating)){
                $rating = new LettersRating();
                $rating->id_user =  Yii::$app->user->id;
                $rating->id_letter = $post['letter_id'];
            }
            $rating->vote_yes = 1;
            $rating->vote_no = 0;
            $rating->save();
            $vote_no_count = LettersRating::find()->where(['id_letter'=>$post['letter_id'],'vote_no'=>1])->count();
            $vote_yes_count = LettersRating::find()->where(['id_letter'=>$post['letter_id'],'vote_yes'=>1])->count();
            $letter = Letters::findOne($post['letter_id']);
            $letter->vote_yes = $vote_yes_count;
            $letter->vote_no = $vote_no_count;
            $letter->rating = $vote_yes_count - $vote_no_count;
            $letter->save();
            $arr = [
                'rating' => $letter->rating,
                'vote_yes' => $vote_yes_count,
                'vote_no' => $vote_no_count,
                'message' => 'no',
            ];
            echo json_encode($arr);
        }
    }

    public function actionRatingDown(){
        if(Yii::$app->user->isGuest)\Yii::$app->session->setFlash('danger', 'Для голосования зарегистрируйтесь или войдите на сайт.');
        $post = \Yii::$app->request->post();
        $rating = LettersRating::findOne([
            'id_user'=>Yii::$app->user->id,
            'id_letter'=>$post['letter_id']
        ]);
        if($rating->vote_no === 1 ){
            $letter = Letters::findOne($post['letter_id']);
            $arr = [
                'rating' => $letter->rating,
                'vote_yes' => 'no',
                'vote_no' => 'no',
                'message' => 'yes',
            ];
            echo json_encode($arr);
        }else{
            if(empty($rating)){
                $rating = new LettersRating();
                $rating->id_user =  Yii::$app->user->id;
                $rating->id_letter = $post['letter_id'];
            }
            $rating->vote_no = 1;
            $rating->vote_yes = 0;
            $rating->save();
            $vote_no_count = LettersRating::find()->where(['id_letter'=>$post['letter_id'],'vote_no'=>1])->count();
            $vote_yes_count = LettersRating::find()->where(['id_letter'=>$post['letter_id'],'vote_yes'=>1])->count();
            $letter = Letters::findOne($post['letter_id']);
            $letter->vote_yes = $vote_yes_count;
            $letter->vote_no = $vote_no_count;
            $letter->rating = $vote_yes_count - $vote_no_count;
            $letter->save();
            $arr = [
                'rating' => $letter->rating,
                'vote_yes' => $vote_yes_count,
                'vote_no' => $vote_no_count,
                'message' => 'no',
            ];
            echo json_encode($arr);
        }
    }

    public function actionCreateComment(){
        if(Yii::$app->user->isGuest)\Yii::$app->session->setFlash('danger', 'Для создания комментариев, зарегистрируйтесь или войдите на сайт.');
        $model  = new LettersComments();
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $text = trim($post['LettersComments']['text']);
            if ($model->validate()&& $text!=''){
                $model->id_user = Yii::$app->user->identity->getId();
                $model->status = 1;
                $model->id_letter = $post['LettersComments']['id_letter'];
                $model->save();
                $letter = Letters::findOne($model->id_letter);
                $letter->comments_count =  Letters::commentsCount($model->id_letter);
                $letter->save();
            }
        }
        return $this->redirect(['view','id'=>$post['letter']]);
    }

    /**
     * Displays a single Letters model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Letters::find()->with('cat')->where(['alias'=>$id,'status'=>1])->andWhere('((unpublish < NOW())OR(unpublish IS NULL))')->asArray()->one();
        if(!empty($model)){
            $query = LettersComments::find()->with('user')->where(['id_letter'=>$model['id'], 'status'=>1])->orderBy('created_at DESC');
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'forcePageParam' => false,
                    'pageSizeParam' => false,
                    'pageSize' => 30,
                ],
            ]);
            $dataProvider->setSort([
                'attributes' => [
                    'created_at' => [
                        'asc' => ['created_at' => SORT_ASC,],
                        'desc' => ['created_at' => SORT_DESC,],
                        'label' => 'По дате',
                    ],
                ],
            ]);
            return $this->render('view', [
                'model' => $model,
                'dataProvider'=>$dataProvider,
            ]);
        }else{
            \Yii::$app->session->setFlash('danger', 'Вы не можете просматривать не опубликованные письма.');
            return $this>$this->redirect(['my-letters']);
        }
    }

    public function actionMyLetters()
    {
        if(Yii::$app->user->isGuest)\Yii::$app->session->setFlash('danger', 'Для голосования зарегистрируйтесь или войдите на сайт.');
        $user = Yii::$app->user->getIdentity();
        $query = Letters::find()->where(['id_user'=>$user->getId()]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('my-letters', [
            'user' => $user,
            'model' => $model,
            'pages' => $pages,
        ]);
    }

    public function actionCreate()
    {
        if(Yii::$app->user->isGuest){
            \Yii::$app->session->setFlash('danger', 'Для создания коллективного письма, зарегистрируйтесь или войдите на сайт.');
            return $this->redirect(['/site/login']);
        }

        $model = new Letters(['scenario'=>'create']);
        if ($model->load(Yii::$app->request->post())) {
            $model->id_user = Yii::$app->user->identity->getId();
            $model->status = 0;
            $model->image = \yii\web\UploadedFile::getInstance($model, 'image');
            if($model->validate()){
                if ($model->save(false)) {
                    \Yii::$app->session->setFlash('success', 'Объявление успешно создано.');
                    return $this->redirect(['my-letters', 'id' => $model->id]);
                }else{
                    \Yii::$app->session->setFlash('danger', 'По каким-то причинам объявление создать не удалось.<br>Пожалуйста повторите попытку.');
                }
            }
            return $this->render('create', ['model' => $model,]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        if(Yii::$app->user->isGuest)\Yii::$app->session->setFlash('danger', 'Для редактирования письма, войдите на сайт.');
        $user = Yii::$app->user->getIdentity();
        $model = Letters::find()->where(['id'=>$id,'id_user'=>$user->getId()])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->image = \yii\web\UploadedFile::getInstance($model, 'image');
            if($model->validate()) {
                if ($model->save()) {
                    \Yii::$app->session->setFlash('success', 'Изменения успешно внесены.');
                    return $this->redirect(['my-letters', 'id' => $model->id]);
                }else{
                    \Yii::$app->session->setFlash('danger', 'По каким-то причинам сохранить изменения не удалось.<br>Пожалуйста повторите попытку.');
                }
            }
            return $this->render('update', [ 'model' => $model,]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
}
