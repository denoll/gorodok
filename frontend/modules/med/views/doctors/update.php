<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\med\Doctors */
$user = Yii::$app->user->getIdentity();
$fio = $user->surname . ' ' . $user->name . ' ' . $user->patronym;
$this->title = 'Изменение данных о докторе: ' . ' ' . $fio;
$this->params['breadcrumbs'][] = ['label' => 'Врачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $fio, 'url' => ['view', 'id' => $model->id_user]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="doctors-update">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h1 style="margin: 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>