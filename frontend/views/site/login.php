<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
?>
<div class="site-login">

    <br>



    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
            <div class="panel panel-u">
                <div class="panel-heading">
                    <h1 style="align-content: center; color: #fff;" class="panel-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="panel-body">
                    <div id="auth_block">
                        <label class="auth-label" for="auth_block">Войдите через один из внешних сервисов.</label>
                        <div class="service-block-auth">
                            <?= yii\authclient\widgets\AuthChoice::widget([
                                'baseAuthUrl' => ['site/auth'],
                                'popupMode' => true,
                            ]) ?>
                        </div>
                        <label class="auth-label standart" for="auth_block">Или войдите стандартным способом.</label>
                    </div>
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

                    <?= $form->field($model, 'rememberMe')->checkbox()->label('запомнить меня') ?>

                    <div style="color:#999;margin:1em 0">
                        Если Вы забыли свой пароль: <?= Html::a('нажмите здесь.', ['site/request-password-reset']) ?>.
                    </div>

                    <div class="form-group" style="margin: 0;">
                        <?= Html::submitButton('Войти', ['class' => 'btn-u btn-block btn-u-dark', 'name' => 'login-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="row tag-box tag-box-v5" style="margin-bottom: 30px;">
                    <h5>Если еще не зарегистрированы нажмите</h5>
                    <?= Html::a('Зарегистрироваться', '/site/signup', ['class' => 'btn-u btn-block btn-u-dark']) ?>
            </div>
        </div>
    </div>
</div>
