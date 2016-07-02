<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\service\Service */

$this->title = 'Изменение объявления: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Мои объявления', 'url' => ['my-ads']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-update">

    <div class="panel panel-dark">
        <div class="panel-heading">
            <h1 class="panel-title"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
