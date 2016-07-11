<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\konkurs\KonkursCat */

$this->title = 'Создание категории конкурсов';
$this->params['breadcrumbs'][] = ['label' => 'Категории конкурсов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="konkurs-cat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
