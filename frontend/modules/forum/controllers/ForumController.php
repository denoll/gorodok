<?php

namespace app\modules\forum\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use common\models\users\User;
use common\models\users\UserProfile;
use common\models\forum\Forums;
use common\models\forum\ForumCat;
use common\models\forum\ForumTheme;
use common\models\forum\ForumMessage;
use common\models\MainMenu;
use common\helpers\IsAdmin;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class ForumController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update','create','create-message','update-message','del-message'],
                'rules' => [
                    [
                        'actions' => ['update','create','create-message','update-message','del-message'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'create' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex($category = null)
    {
        if($category != null){
            $forums = Forums::find()->with('forumCatsFront')->where(['status' => '1','alias'=>$category])->orderBy('order')->all();
        }else{
            $forums = Forums::find()->with('forumCatsFront')->where(['status' => '1'])->andWhere(['on_main' => '1'])->orderBy('order')->all();
        }
        return $this->render('index', [
            'forums' => $forums,
        ]);
    }

    public function actionCategory($id)
    {
        $forum_cat = ForumCat::findOne(['alias' => $id]);
        $forum = Forums::findOne(['id' => $forum_cat->id_forum]);
        $f_theme = ForumTheme::find()->with('tags')->where(['id_cat' => $forum_cat->id])->andWhere('status = 1 OR status = 2')->orderBy('order');
        $countF_theme = clone $f_theme;
        $pages = new Pagination(['totalCount' => $countF_theme->count()]);
        $pages->setPageSize(15);
        $forum_theme = $f_theme->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $session = Yii::$app->session;
        $session->open();
        $session->set('forum_cat_id', $forum_cat->id);
        $session->set('forum_cat_alias', $forum_cat->alias);
        $session->set('forum_cat_name', $forum_cat->name);
        $session->close();
        return $this->render('category', [
            'forum' => $forum,
            'forum_cat' => $forum_cat,
            'forum_theme' => $forum_theme,
            'pages' => $pages,
        ]);
    }

    public function actionCreate()
    {
        if (!Yii::$app->user->isGuest) {
            //$id_cat = Yii::$app->request->post('id_cat');
            $user = User::findOne(Yii::$app->user->id);
            $session = Yii::$app->session;
            $session->open();
            $id_cat = $session->get('forum_cat_id');
            $alias_cat = $session->get('forum_cat_alias');
            $name_cat = $session->get('forum_cat_name');
            $session->close();
            $model = new ForumTheme();
            $post = \Yii::$app->request->post();
            if ($model->load($post)) {
                $model->m_description = $post['ForumTheme']['name'];
                $model->m_keyword = $post['ForumTheme']['name'];
                $model->id_cat = $id_cat;
                $model->id_author = Yii::$app->user->identity->getId();
               if ($model->save()) {
                    return $this->redirect(['theme', 'id' => $model->alias]);
               } else {
                   return $this->render('create', [
                       'model' => $model,
                       'id_cat' => $id_cat,
                   ]);
               }
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'id_cat' => $id_cat,
                    'alias_cat' => $alias_cat,
                    'name_cat' => $name_cat,
                ]);
            }
        }
    }

    public function actionUpdate($id)
    {
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->getIdentity();
            $session = Yii::$app->session;
            $session->open();
            $id_cat = $session->get('forum_cat_id');
            $alias_cat = $session->get('forum_cat_alias');
            $name_cat = $session->get('forum_cat_name');
            $session->close();
            $model = ForumTheme::findOne($id);

            if($user->getId() == $model->id_author || User::isAdmin()){
                $post = Yii::$app->request->post();
                if ($model->load($post)) {
                    $model->m_description = $post['ForumTheme']['name'];
                    $model->m_keyword = $post['ForumTheme']['name'];
                    $model->id_cat = $id_cat;
                    $model->id_author = $user->getId();
                    if ($model->save()) {
                        return $this->redirect(['theme', 'id' => $model->alias]);
                    } else {
                        return $this->render('update', [
                            'model' => $model,
                            'id_cat' => $id_cat,
                            'alias_cat' => $alias_cat,
                            'name_cat' => $name_cat,
                        ]);
                    }
                } else {
                    return $this->render('update', [
                        'model' => $model,
                        'id_cat' => $id_cat,
                        'alias_cat' => $alias_cat,
                        'name_cat' => $name_cat,
                    ]);
                }
            }else{
                return $this->redirect(['index']);
            }
        }
    }

    public function actionTheme($id)
    {
        $model = ForumTheme::find()->with('idAuthor')->where(['alias' => $id])->andWhere('status = 1 OR status = 2')->one();
        $messages = ForumMessage::find()
            ->with('idCat')
            ->with('idTheme')
            ->with('idAuthor')
            ->with('auth')
            ->where(['id_theme'=>$model['id']]);
            //->andWhere(['status'=>1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $messages,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 20,
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
        $model->updateCounters(['views' => 1]); //Кол-во просмотров
        return $this->render('theme', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            //'forumAndCat' => $forumAndCat,
        ]);
    }

    public function actionCreateMessage ()
    {
        $message = new ForumMessage();
        $post = Yii::$app->request->post();
        if ($message->load($post) && $post['ForumMessage']['message'] != '') {
            $message->id_author = Yii::$app->user->id;
            $message->id_cat = $post['ForumMessage']['id_cat'];
            $message->id_theme = $post['ForumMessage']['id_theme'];
            $message->message = $post['ForumMessage']['message'];
            if ($message->save()) {
                Yii::$app->session->setFlash('info','Сообщение успешно опубликовано');
            }else{
                Yii::$app->session->setFlash('danger','Сообщение не опубликовано');
            }
        }
        return $this->redirect(['theme','id'=>$post['theme_alias']]);
    }

    public function actionUpdateMessage($id)
    {
        $message = ForumMessage::find()->with('idCat')->with('idTheme')->where(['id'=>$id])->one();
        if ($message->id_author == Yii::$app->user->id || $message->idTheme->id_author == Yii::$app->user->id || User::isAdmin()) {
            $post = Yii::$app->request->post('ForumMessage');
            if ($post) {
                $message->message = $post['message'];
                $message->status = $post['status'];
                $message->save();
                unset($_POST['ForumMessage']);
                return $this->redirect(['theme', 'id' => $message->idTheme->alias]);
            } else {
                return $this->render('update-message', [
                    'message' => $message,
                ]);
            }
        } else {
            return $this->redirect(['theme', 'id' => $message->idTheme->alias]);
        }
    }

    public function actionDelMessage($id)
    {
        $user_id = Yii::$app->user->identity->getId();
        $user = User::findOne($user_id);
        $message = ForumMessage::findOne($id);
        $theme = ForumTheme::findOne(['id' => $message->id_theme]);
        if ($message->id_author == Yii::$app->user->id || $theme->id_author == Yii::$app->user->id || User::isAdmin()) {
            $message->delete();
            $count_message = ForumMessage::find()->where(['id_author' => $user_id, 'status' => 1])->count();
            $user->count_fm = $count_message;
            $user->save();
        }
        return $this->redirect(['theme', 'id' => $theme->alias]);
    }
}
