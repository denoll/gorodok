<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 04.06.2016
 * Time: 12:45
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\widgets\Arrays;
use kartik\widgets\SwitchInput;

?>

<div class="col-md-6">
	<div id="auth_block">
		<label for="auth_block">Зарегестрируйтесь через один из внешних сервисов.</label>
		<div class="service-block-auth">
			<?= yii\authclient\widgets\AuthChoice::widget([
				'baseAuthUrl' => ['site/auth'],
				'popupMode' => true,
			]) ?>
		</div>
		<label for="auth_block">Или пройдите регистрацию стандартным способом.</label>
	</div>
</div>
