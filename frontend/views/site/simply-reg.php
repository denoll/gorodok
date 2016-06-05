<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model_signup \frontend\models\SignupForm */
/* @var $model_login \common\models\LoginForm */
/* @var string $message */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\widgets\Arrays;
use kartik\widgets\SwitchInput;

$this->title = 'Регистрация';
?>
<div class="site-signup">

	<br>

	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="tab-v1">
				<?= \yii\bootstrap\Tabs::widget([
					'items' => [
						[
							'label' => 'Зарегистрироваться',
							'content' => $this->render('tabs/_signup', [
								'model_signup' => $model_signup,
							]),
						],
						[
							'label' => 'Войти если уже регистрировались',
							'content' => $this->render('tabs/_login', [
								'model_login' => $model_login,
							]),
						],
					],
				]);
				?>
			</div>
		</div>
		<div class="col-md-4">
			<blockquote>
				<h2>Перед подачей <?= $message ?>, Вам нужно</h2>
				<p>Войти на сайт или зарегистрироваться, если еще не проходили процедуру регистрации.</p>
				<p>Это достаточно просто сделать в окошке слева.</p>
				<p>После регистрации или входа на сайт Вы сразу попадете на страницу добавления <?= $message ?>.</p>
				<hr>
				<i class="text-small">Все объявления должны соответствовать правилам городского портала <?= Html::a('Подробнее...',['/page/page/view', 'id'=>'rules'],['target'=>'_blank']) ?></i><br>
				<i class="text-small">Регистрируясь на сайте Вы даете свое согласие на обработку пресональных данных. <?= Html::a('Подробнее...',['/page/page/view', 'id'=>'rules'],['target'=>'_blank']) ?></i>
			</blockquote>
		</div>

	</div>
</div>
<!--<script src='https://www.google.com/recaptcha/api.js?hl=<?= \common\widgets\captcha\Captcha::getLanguage() ?>'></script>-->
<?php
$this->registerCss('.form-group{margin-bottom: 0px;} .tab-content{padding-top: 0 !important;}');

?>
