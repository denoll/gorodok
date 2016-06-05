<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\users\UserAccount */

$this->title = 'Изменение платежа №: - ' . $model->invoice;
$this->params['breadcrumbs'][] = ['label' => 'Все платежи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->invoice, 'url' => ['view', 'id' => $model->id]];
?>
<div class="user-account-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
    ]) ?>

</div>
