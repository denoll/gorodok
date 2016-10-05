<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User: Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 19.09.2016
 * Time: 13:09
 */

use yii\jui\DatePicker;
use yii\bootstrap\Html;

$action = Yii::$app->controller->action->id;

if($action == 'plane'){
	$plane = 'btn-u';
	$train = 'btn-default';
	$suburban = 'btn-default';
	$bus = 'btn-default';
}elseif($action == 'train'){
	$plane = 'btn-default';
	$train = 'btn-u';
	$suburban = 'btn-default';
	$bus = 'btn-default';
}elseif($action == 'suburban'){
	$plane = 'btn-default';
	$train = 'btn-default';
	$suburban = 'btn-u';
	$bus = 'btn-default';
}elseif($action == 'bus'){
	$plane = 'btn-default';
	$train = 'btn-default';
	$suburban = 'btn-default';
	$bus = 'btn-u';
}

?>

<div class="panel panel-default">
	<div class="panel-body">

		<div class="btn-group btn-group-justified">
			<form method="get">
				<div class="btn-group padding-3">
					<?= Html::a('<i class="fa fa-train"></i>&nbsp;&nbsp;&nbsp;Поезда',['/schedule/default/train'], ['class'=>'btn '.$train]); ?>
				</div>
				<div class="btn-group padding-3">
					<?= Html::a('<i class="fa fa-train"></i>&nbsp;&nbsp;&nbsp;Электрички',['/schedule/default/suburban'], ['class'=>'btn '.$suburban]); ?>
				</div>

				<div class="btn-group padding-3">
					<?= Html::a('<i class="fa fa-plane"></i>&nbsp;&nbsp;&nbsp;Авиа',['/page/page/view', 'cat' => 'poleznaa-informacia','id'=>'raspisanie-samoletov'], ['class'=>'btn '.$plane]); ?>
				</div>
				<div class="btn-group padding-3">
					<?= Html::a('<i class="fa fa-bus"></i>&nbsp;&nbsp;&nbsp;Автобусы',['/page/page/view', 'cat' => 'poleznaa-informacia','id'=>'raspisanie-avtobusov'], ['class'=>'btn '.$bus]); ?>
				</div>
				<div class="btn-group padding-3">
					<table>
						<tr>
							<td><span>&nbsp;На дату:</span></td>
							<td>
								<?= DatePicker::widget([
									'language'      => 'ru',
									'name'          => 'date',
									'options'       => [
										'class' => 'form-control',
									],
									'clientOptions' => [
										'dateFormat' => 'yy-mm-dd',
										'showButtonPanel' => 'true',
										'changeMonth' => 'true',
										'changeYear' => 'true',
									],
								]); ?>
							</td>
							<td>
								<button type="submit" class="btn-u">Показать</button>
							</td>
						</tr>
					</table>
				</div>
			</form>

		</div>

	</div>
</div>

<?php
$css = <<<CSS
	.padding-3{
	padding-top: 3px;
	padding-bottom: 3px;
	}
CSS;

	$this->registerCss($css);
?>
