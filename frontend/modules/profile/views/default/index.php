<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use \common\models\users\User;
/* @var $this yii\web\View */
/* @var $model common\models\users\User */

$this->params['left'] = true;

$this->title = 'Профиль пользователя:  ' . $model->username;
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$labels = $model->attributeLabels();

if(User::isCompany()){
    $btn_change_username = 'изменить компанию';
}else{
    $btn_change_username = 'изменить логин';
}

?>
<div class="user-view">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h1 style="margin: 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?>. &nbsp;&nbsp;&nbsp; <i class="small-text"><?= User::isCompany() ? 'Вы зарегистрированы как компания' : 'Вы зарегистрированы как частное лицо' ?></i></h1>

        </div>
        <div class="panel-body">
            <dl class="dl-horizontal">
                <hr style="margin: 5px 0px;">
                <dt><?= $labels['username'] ?>:</dt>
                <dd><?= $model['username'] ?>

                    <?= \yii\bootstrap\Modal::widget([
                        'header' => '<i>'.$btn_change_username.'</i>',
                        'id' => 'change-login-btn',
                        'toggleButton' => [
                            'label' => '<i>'.$btn_change_username.'</i>',
                            'class' => 'btn-u btn-brd rounded-2x btn-u-light-green btn-u-xs pull-right',
                            'style' => 'font-size: 0.8em; text-align:center; width:160px; padding: 2px 5px 4px 5px; line-height: 14px; margin-left:35px;',
                            'tag' => 'a',
                            'data-target' => '#change-login-btn',
                            'href' => Url::home() . 'profile/change-login',
                        ],
                        'clientOptions' => false,
                    ]); ?>
                </dd>
                <hr style="margin: 5px 0px;">
                <dt><?= $labels['email'] ?>:</dt>
                <dd><?= $model['email'] ?>
                    <?= \yii\bootstrap\Modal::widget([
                        'header' => '<i> изменить email </i>',
                        'id' => 'change-email-btn',
                        'toggleButton' => [
                            'label' => '<i> изменить email </i>',
                            'class' => 'btn-u btn-brd rounded-2x btn-u-light-green btn-u-xs pull-right',
                            'style' => 'font-size: 0.8em; text-align:center; width:160px; padding: 2px 5px 4px 5px; line-height: 14px; margin-left:35px;',
                            'tag' => 'a',
                            'data-target' => '#change-email-btn',
                            'href' => Url::home() . 'profile/change-email',
                        ],
                        'clientOptions' => false,
                    ]); ?>
                </dd>
                <hr style="margin: 5px 0px;">
                <dt>Ф.И.О.</dt>
                <dd><?= $model['surname'] . ' ' . $model['name'] . ' ' . $model['patronym'] ?>
                    <?= \yii\bootstrap\Modal::widget([
                        'header' => '<i> изменить ФИО </i>',
                        'id' => 'change-fio-btn',
                        'toggleButton' => [
                            'label' => '<i> изменить ФИО </i>',
                            'class' => 'btn-u btn-brd rounded-2x btn-u-light-green btn-u-xs pull-right',
                            'style' => 'font-size: 0.8em; text-align:center; width:160px; padding: 2px 5px 4px 5px; line-height: 14px; margin-left:35px;',
                            'tag' => 'a',
                            'data-target' => '#change-fio-btn',
                            'href' => Url::home() . 'profile/change-fio',
                        ],
                        'clientOptions' => false,
                    ]); ?>
                </dd>
                <hr style="margin: 5px 0px;">
                <dt><?= $labels['tel'] ?>:</dt>
                <dd><?= $model['tel'] ?>
                    <?= \yii\bootstrap\Modal::widget([
                        'header' => '<i> Изменить телефон </i>',
                        'id' => 'change-tel-btn',
                        'toggleButton' => [
                            'label' => '<i> изменить телефон </i>',
                            'class' => 'btn-u btn-brd rounded-2x btn-u-light-green btn-u-xs pull-right',
                            'style' => 'font-size: 0.8em; text-align:center; width:160px; padding: 2px 5px 4px 5px; line-height: 14px; margin-left:35px;',
                            'tag' => 'a',
                            'data-target' => '#change-tel-btn',
                            'href' => Url::home() . 'profile/change-tel',
                        ],
                        'clientOptions' => false,
                    ]); ?>
                </dd>
                <hr style="margin: 5px 0px;">
                <dt>Пароль:</dt>
                <dd>*******
                    <?= \yii\bootstrap\Modal::widget([
                        'header' => '<i> Изменить пароль </i>',
                        'id' => 'change-pass-btn',
                        'toggleButton' => [
                            'label' => '<i> изменить пароль </i>',
                            'class' => 'btn-u btn-brd rounded-2x btn-u-light-green btn-u-xs pull-right',
                            'style' => 'font-size: 0.8em; text-align:center; width:160px; padding: 2px 5px 4px 5px; line-height: 14px; margin-left:35px;',
                            'tag' => 'a',
                            'data-target' => '#change-pass-btn',
                            'href' => Url::home() . 'profile/change-password',
                        ],
                        'clientOptions' => false,
                    ]); ?>
                </dd>
                <hr style="margin: 5px 0px;">
            </dl>
        </div>
    </div>
</div>
<pre>
    <?php
    $identity = Yii::$app->getUser()->getIdentity();
    print_r($identity);
    ?>
</pre>
