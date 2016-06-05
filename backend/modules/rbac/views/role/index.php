<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/**
 * @var yii\web\View                       $this
 * @var yii\data\ActiveDataProvider        $dataProvider
 * @var app\modules\rbac\models\AuthItemSearch $searchModel
 */
$this->title = 'Роли пользователей';
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>
<div class="role-index">

    <h2><?php echo Html::encode($this->title); ?></h2>

    <p>
        <?php echo Html::a('Создать новую роль', ['create'], ['class' => 'btn btn-success']); ?>
    </p>

    <?php Pjax::begin(['enablePushState' => false, 'timeout' => 5000]); ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'description:ntext',
            ['class' => 'yii\grid\ActionColumn',],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
