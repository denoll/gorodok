<?php

use yii\helpers\Html;
use app\modules\afisha\Module;

/* @var $this yii\web\View */
/* @var $model common\models\Afisha */

$this->title = 'Изменить публикацию: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Афиша', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="afisha-update">

    <?= $this->render('_form', [
        'model' => $model,
        'module' => $module,
    ]) ?>

</div>
