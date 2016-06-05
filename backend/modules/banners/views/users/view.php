<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerUsers */

$this->title = $model->company_name;
$this->params['breadcrumbs'][] = ['label' => 'Рекламодатели', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этого рекламодателя?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'company_name',
            'fio',
            'tel',
            'email:email',
            'description:ntext',
        ],
    ]) ?>

</div>
