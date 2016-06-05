<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\med\DoctorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$user = Yii::$app->user->getIdentity();

$this->params['right'] = true;
$this->params['left'] = true;
$this->params['is_company'] = $user->company;
$this->params['is_doctor'] = $user->doctor;
$this->title = 'Врачи';
$this->params['breadcrumbs'][] = $this->title;

?>
<style type="text/css">
    .help-block {
        margin: 0px !important;
    }

    .form-control {
        height: 35px;
    }
</style>
<div class="doctors-index">
    <div class="row">
        <div class="col-md-6"><h1><?= Html::encode($this->title) ?></h1></div>
        <?php/* if (!$user->company) { ?>
            <?php if ($user->doctor) { ?>
                <div class="col-md-6"><?= Html::a('<i class="fa fa-edit"></i>&nbsp;&nbsp;Редактировать свои медицинские данные', ['update'], ['class' => 'btn btn-success pull-right']) ?></div>
            <?php } else { ?>
                <div class="col-md-6"><?= Html::a('<i class="fa fa-user-md"></i>&nbsp;&nbsp;Я врач, и хочу появиться на сайте', ['create'], ['class' => 'btn btn-success pull-right']) ?></div>
            <?php } ?>
        <?php }*/ ?>
    </div>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'layout' => '<div class="sorter-block"><i class="small-text">Сортировать:</i> {sorter} {summary} {pager}</div> {items} {pager}',
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        // 'itemView' => function ($model, $key, $index, $widget) {
        //    return Html::a(Html::encode($model->id_user), ['view', 'id' => $model->id_user]);
        //},
    ]) ?>

</div>
