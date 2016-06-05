<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\users\UserAccount */

$this->title = 'Пополнение баланса пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Все платежи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-account-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
    ]) ?>

</div>
