<?php

use yii\helpers\Html;
use yii\helpers\Url;


/**
 * @var yii\web\View                         $this
 * @var yii\data\ActiveDataProvider          $dataProvider
 * @var app\modules\rbac\models\AssignmentSearch $searchModel
 */
$this->title = 'Назначение ролей пользователям';
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>
    <div class="assignment-index">
        <h2>Роли для пользователя: <?php echo $model->{$usernameField}; ?></h2>

        <div class="row">
            <div class="col-lg-5">
	            <label for="available">Роли</label>
                <?php
                echo Html::textInput('search_av', '', [
		                'id'=>'user-up',
                        'class' => 'role-search form-control',
                        'data-target' => 'available',
                        'placeholder' => 'Найти роль:'
                    ]) . '<br>';
                echo Html::listBox('roles', '', $available, [
                    'id' => 'available',
                    'multiple' => true,
                    'size' => 20,
                    'style' => 'width:100%',
                    'class' => 'form-control'
                ]);
                ?>
            </div>
            <div class="col-lg-2">
                <div class="move-buttons">
                    <?php
                    echo Html::a('<i class="glyphicon glyphicon-chevron-left"></i>', '#', [
                        'class' => 'btn btn-success',
                        'data-action' => 'delete'
                    ]);
                    ?>
                    <?php
                    echo Html::a('<i class="glyphicon glyphicon-chevron-right"></i>', '#', [
                        'class' => 'btn btn-success',
                        'data-action' => 'assign'
                    ]);
                    ?>
                </div>
            </div>
            <div class="col-lg-5">
	            <label for="assigned">Роли</label>
                <?php
                echo Html::textInput('search_asgn', '', [
		                'id'=>'user-drop',
                        'class' => 'role-search form-control',
                        'data-target' => 'assigned',
                        'placeholder' => 'Найти роль:'
                    ]) . '<br>';
                echo Html::listBox('roles', '', $assigned, [
                    'id' => 'assigned',
                    'multiple' => true,
                    'size' => 20,
                    'style' => 'width:100%',
                    'class' => 'form-control',
                ]);
                ?>
            </div>
        </div>
    </div>
<?php
$this->registerJs("rbac.init({
        name: " . json_encode($id) . ",
        route: '" . Url::toRoute(['role-search']) . "',
        routeAssign: '" . Url::toRoute(['assign', 'id' => $id, 'action' => 'assign']) . "',
        routeDelete: '" . Url::toRoute(['assign', 'id' => $id, 'action' => 'delete']) . "',
        routeSearch: '" . Url::toRoute(['route-search']) . "'
    });", yii\web\View::POS_READY);
