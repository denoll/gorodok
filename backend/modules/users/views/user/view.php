<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\users\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <p>
        <?= Html::a('<i class="fa fa-edit"></i>  Изменить пользователя', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash"></i>  Удалить пользователя', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить данного пользователя?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'name',
            'surname',
            'patronym',
            'confirmed_at',
            'blocked_at',
            'status',
            'created_at',
            'updated_at',
            'rating',
            'flags',
            'lat',
            'long',
            'ip',
            'avatar',
            'count_fm',
            'count_ft',
            'auth_key',
            'password_hash',
        ],
    ]) ?>

</div>
