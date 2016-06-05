<?php

namespace app\modules\jobs\controllers;

use common\models\CommonQuery;
use common\models\jobs\JobCategory;
use common\models\jobs\JobCatVac;
use common\models\jobs\JobVacancy;
use common\models\jobs\VacancySearch;
use common\models\users\User;
use common\models\users\UserAccount;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\SeoFunc;
use yii\db\Expression;
use common\widgets\Arrays;
use yii\filters\AccessControl;

/**
 * ResumeController implements the CRUD actions for JobResume model.
 */
class VacancyController extends Controller
{

    const VIP_PAY = 100;
    const TOP_PAY = 30;
    const UP_PAY = 30;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['my-vacancy', 'change-status', 'change-up', 'change-vip', 'create', 'update', 'cat-del', 'delete'],
                'rules' => [
                    [
                        'actions' => ['my-vacancy', 'change-status', 'change-up', 'change-vip', 'create', 'update', 'cat-del', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
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
    public function beforeAction($action)
    {
        if($action->id == 'create'){
            Yii::$app->user->loginUrl = ['/site/simply-reg','v'=>3];
        }
        return parent::beforeAction($action);
    }
    /**
     * Lists all JobVacancy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VacancySearch();
        $search = $searchModel->search(Yii::$app->request->queryParams);
        if ($search) {
            $dataProvider = $search;
            return $this->render('index', [
                'items' => true,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('index', [
                'items' => false,
            ]);
        }
    }

    /**
     * Displays a single JobResume model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        //$model = User::find()->joinWith('exp')->joinWith('edu')->joinWith('resume')->joinWith('profile')->asArray()->where(['job_resume.id'=>$id])->one();
        $vac = JobVacancy::find()->where(['id' => $id])->asArray()->one();
        $user = User::find()->with('company')->where(['id' => $vac['id_user']])->asArray()->one();
        return $this->render('view', [
            'vac' => $vac,
            'user' => $user,

        ]);
    }

    /**
     * Lists all JobVacancy models.
     * @return mixed
     */
    public function actionMyVacancy()
    {
        $user = Yii::$app->user->getIdentity();
        if ($user['company']) {
            $model = JobVacancy::find()->asArray()->where(['id_user' => $user->getId()])->all();
            return $this->render('my-vacancy', [
                'user' => $user,
                'model' => $model,
            ]);
        } else {
            \Yii::$app->session->setFlash('info', 'Для подачи вакансии Вы должны зарегистрироваться как компания.');
            return $this->redirect(Url::home());
        }

    }

    /**
     * Change status JobVacancy models.
     * @return mixed
     */
    public function actionChangeStatus()
    {
        $post = \Yii::$app->request->post('vac_id');
        if ($post) {
            $user = Yii::$app->user->getIdentity();
            $model = JobVacancy::findOne(['id' => $post, 'id_user' => $user->getId()]);
            if ($model->status == 1) {
                $model->status = 0;
            } else {
                $model->status = 1;
            }
            if ($model->save()) {
                echo $model->status == 1 ? 'all' : 'me';
                \Yii::$app->session->setFlash('success', 'Статус изменен.');

            } else {
                \Yii::$app->session->setFlash('danger', 'Статус не изменен.');
            }
        }
    }

    /**
     * Поднятие объявления updated_at JobVacancy models.
     * @return mixed
     */
    public function actionChangeUp()
    {
        $pay = Arrays::PAYMENTS();
        $post = \Yii::$app->request->post('vac_id');
        if ($post) {
            $user = Yii::$app->user->getIdentity();
            $model = JobVacancy::findOne(['id' => $post, 'id_user' => $user->getId()]);
            $m_user = User::findOne($user->getId());
            $u_account = new UserAccount();
            if ($user->account >= $pay['vac_up_pay']) {
                $m_user->account = (integer)$user->account - (integer)$pay['vac_up_pay'];
                $model->updated_at = new Expression('NOW()');
                $u_account->id_user = $user->getId();
                $u_account->pay_out = $pay['vac_up_pay'];
                $u_account->invoice = 'VAC-UP-' . $model->id . '-' . rand(10000, 99999);
                $u_account->date = new Expression('NOW()');
                $u_account->description = 'Поднятие вакансии №' . $model->id . '.';

                if ($model->save() && $m_user->save(false) && $u_account->save()) {
                    $arr = [
                        'account' => $m_user->account,
                        'pay' => $pay['vac_up_pay'],
                        'date' => date('Y-m-d'),
                        'message' => 'Объявление поднято на верх. С вашего счета списано ' . $pay['vac_up_pay'] . 'руб.',
                        'm_type' => 'success'
                    ];
                    echo json_encode($arr);
                } else {
                    $arr = [
                        'message' => 'Объявление не поднято',
                        'm_type' => 'danger'
                    ];
                    echo json_encode($arr);
                }
            } else {
                $arr = [
                    'message' => 'Объявление не поднято. На вашем счёте недостаточно средств.',
                    'm_type' => 'danger'
                ];
                echo json_encode($arr);
            }

        }
    }

    /**
     * Выделение и поднятие объявления vip, updated_at в JobResume models.
     * @return mixed
     */
    public function actionChangeVip()
    {
        $pay = Arrays::PAYMENTS();
        $period = Arrays::getConst();
        $post = \Yii::$app->request->post('vac_id');
        if ($post) {
            $user = Yii::$app->user->getIdentity();
            $model = JobVacancy::findOne(['id' => $post, 'id_user' => $user->getId()]);
            $m_user = User::findOne($user->getId());
            $u_account = new UserAccount();
            if ($user->account >= $pay['vac_vip_pay']) {
                $m_user->account = (integer)$m_user->account - (integer)$pay['vac_vip_pay'];
                $u_account->id_user = $user->getId();
                $u_account->pay_out = $pay['vac_vip_pay'];
                $u_account->invoice = 'VAC-VIP-' . $model->id . '-' . rand(10000, 99999);
                $u_account->date = new Expression('NOW()');
                $u_account->description = 'Выделение вакансии №' . $model->id . '.';
                $model->vip_date = new Expression('NOW()');
                $model->updated_at = new Expression('NOW()');
                if ($model->save() && $m_user->save(false) && $u_account->save()) {
                    $arr = [
                        'account' => $m_user->account,
                        'pay' => $pay['vac_vip_pay'],
                        'date' => date('Y-m-d'),
                        'message' => 'Объявление выделено на ( ' . $period['vip'] . ' )дней и поднято на верх. С вашего счета списано ' . $pay['vac_vip_pay'] . 'руб.',
                        'm_type' => 'success'
                    ];
                    echo json_encode($arr);
                } else {
                    $arr = [
                        'message' => 'Объявление выделено и не поднято.',
                        'm_type' => 'danger'
                    ];
                    echo json_encode($arr);
                }
            } else {
                $arr = [
                    'message' => 'Объявление выделено и не поднято. На вашем счёте недостаточно средств.',
                    'm_type' => 'danger'
                ];
                echo json_encode($arr);
            }

        }
    }


    /**
     * Creates a new JobVacancy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $user = \Yii::$app->user->getIdentity();
        if ($user['company']) {
            $model = new JobVacancy();
            $post = \Yii::$app->request->post();
            if ($model->load($post)) {
                $user_id = $user['id'];
                $model->id_user = $user_id;
                $model->m_description = $this->genDescription($post['JobVacancy']['title'], mb_strimwidth($post['JobVacancy']['description'], 0, 170));
                if ($post['cbx']) {
                    $model->m_keyword = $this->genKeywords($post['cbx'], $post['JobVacancy']['title']);
                }
                if ($model->save()) {
                    \Yii::$app->session->setFlash('success', 'Изменения успешно внесены.');
                } else {
                    \Yii::$app->session->setFlash('danger', 'Внести изменения не получилось, внимательно проверьте все поля на корректность ввода.');
                }
                if ($post['cbx']) {
                    $catRes = JobCatVac::find()->where(['id_vac' => $model->id])->asArray()->all();
                    $count = count($catRes) + count($post['cbx']);
                    if ($count <= 5) {
                        foreach ($post['cbx'] as $item) {
                            $arr[] = [$model->id, $item];
                        }
                        $db = Yii::$app->db;
                        $db->createCommand()->batchInsert('job_cat_vac', ['id_vac', 'id_cat'], $arr)->execute();
                    } else {
                        \Yii::$app->session->setFlash('danger', '<h3>Изменить категории не получилось.</h3> Выбранных категорий должно быть меньше пяти.');
                    }
                }
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            \Yii::$app->session->setFlash('info', 'Для подачи вакансии Вы должны зарегистрироваться как компания.');
            return $this->redirect(Url::home());
        }

    }

    /**
     * Updates an existing JobVacancy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $user = \Yii::$app->user->getIdentity();
        if ($user['company']) {
            $user_id = $user['id'];
            $model = $this->findModel(['id' => $id, 'id_user' => $user_id]);
            $post = \Yii::$app->request->post();
            if ($model->load($post)) {
                $model->id_user = $user_id;
                if ($post['cbx']) {
                    $catRes = JobCatVac::find()->where(['id_vac' => $model->id])->asArray()->all();
                    $count = count($catRes) + count($post['cbx']);
                    if ($count <= 5) {
                        foreach ($post['cbx'] as $item) {
                            $arr[] = [$id, $item];
                        }
                        $db = Yii::$app->db;
                        $db->createCommand()->batchInsert('job_cat_vac', ['id_vac', 'id_cat'], $arr)->execute();
                        $model->m_keyword = $this->genKeywords($post['cbx'], $post['JobVacancy']['title']);
                    } else {
                        \Yii::$app->session->setFlash('danger', '<h3>Изменить категории не получилось.</h3> Выбранных категорий должно быть меньше пяти.');
                    }
                }
                $model->m_description = $this->genDescription($post['JobVacancy']['title'], mb_strimwidth($post['JobVacancy']['description'], 0, 170));
                if ($model->save()) {
                    \Yii::$app->session->setFlash('success', 'Изменения успешно внесены.');
                } else {
                    \Yii::$app->session->setFlash('danger', 'Внести изменения не получилось, внимательно проверьте все поля на корректность ввода.');
                }
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                $_cat = new JobCatVac();
                $cat = $_cat->listCategory($id);

                return $this->render('update', [
                    'model' => $model,
                    'cat' => $cat,
                ]);
            }
        } else {
            \Yii::$app->session->setFlash('info', 'Для подачи вакансии Вы должны зарегистрироваться как компания.');
            return $this->redirect(Url::home());
        }
    }

    private function genKeywords($cbx, $data)
    {
        if (is_array($cbx) && count($cbx) > 0) {
            $cat = JobCategory::find()->select('name')->where(['id' => $cbx])->asArray()->all();
            foreach ($cat as $item) {
                $arr[] = $item['name'];
            }
            return SeoFunc::generateKeywords($arr, $data);
        } else {
            return false;
        }
    }

    private function genDescription($text, $data)
    {
        if ($text != '' || $data != '') {
            return SeoFunc::generateDescription($text, $data);
        } else {
            return false;
        }
    }

    public function actionCatDel()
    {
        $post = \Yii::$app->request->post();
        if ($post) {
            $list = JobCatVac::findOne($post['cat_id']);
            $list->delete();
        }
    }


    /**
     * Deletes an existing JobVacancy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $item = $this->findModel($id);
        $user = Yii::$app->user->identity;
        if($user->id == $item->id_user){
            CommonQuery::deleteItem($item);
        }
        return $this->redirect(['my-vacancy']);
    }

    /**
     * Finds the JobVacancy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return JobVacancy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JobVacancy::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
