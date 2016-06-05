<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use frontend\widgets\JobSearch;
/* @var $this yii\web\View */
/* @var $searchModel common\models\jobs\JobResumeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вакансии';
$this->params['left'] = true;
$this->params['right'] = true;
$get = Yii::$app->request->get();
if(!empty($get['cat'])||!empty($get['VacancySearch']['cat'])){
    if(!empty($get['cat'])){
        $id_cat = $get['cat'];
    }else{
        $id_cat = $get['VacancySearch']['cat'];
    }
    $this->params['breadcrumbs'][] = ['label' => 'Вакасии', 'url' => [Url::home().'jobs/vacancy/index']];
    $cat = \common\widgets\Arrays::getJobCatBiId($id_cat);
    $this->title = $cat['name'];
    $m_kw = $cat['m_keyword'];
    $m_d = $cat['m_description'];
}else{
    $m_kw = 'каталог, вакансий, работа и вакансии в тынде, работа в тынде, рабочие места в тынде';
    $m_d = 'Каталог объявлений о работе в Тынде. Здесь Вы можете опубликовать свои вакансии.';
}
$this->params['breadcrumbs'][] = $this->title;
if (!empty($m_d)) {
    $this->registerMetaTag(['content' => Html::encode($m_d), 'name' => 'description']);
}
if (!empty($m_kw)) {
    $this->registerMetaTag(['content' => Html::encode($m_kw), 'name' => 'keywords']);
}
$user = Yii::$app->user->getIdentity();

?>
<style type="text/css">
    .help-block{
        margin: 0px !important;
    }
    .form-control{
        height: 35px;
    }
</style>
<div class="job-resume-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if($items){ ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'layout' => '<div class="sorter-block"><i class="small-text">Сортировать:</i> {sorter} {summary} {pager}</div> {items} {pager}',
    ]); ?>
    <?php }else{ ?>
        <div class="alert alert-success fade in">
            <strong>Ничего не найдено!</strong>
        </div>
    <?php } ?>

</div>
