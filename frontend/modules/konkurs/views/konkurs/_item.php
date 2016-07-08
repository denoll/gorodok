<?php
use yii\helpers\Html;
use \yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use frontend\widgets\Avatar;
use \common\widgets\Arrays;

?>
<div class="item">
	<div class="margin-bottom-10">
		<div class="container-fluid" style="border: 1px #cfcfcf solid; padding: 1px; 10px; margin: 0px;">
			<div class="col-sm-2 side_left sm-margin-bottom-20">
				<div class="thumbnail" style="padding: 1px; margin: 15px 0px 17px 0px;">
					<?= Html::a(\common\helpers\Thumb::img($model['base_url'],$model['img'], '100%'), ['/konkurs/konkurs/view', 'id' => $model['slug']]) ?>
				</div>
			</div>
			<div class="col-md-10 side_left">
				<h2 style="margin: 5px 0px;">
					<?= Html::a(Html::encode($model['name']), ['/konkurs/konkurs/view', 'id' => $model['slug']]) ?>
				</h2>
				<p>
					<?= $model['title']; ?>
				</p>
				<i class="small-text">Начало: </i>&nbsp;<span style="font-weight: bold;"><?= $model['start'] ? $model['start'] : 'не указано' ?></span></br>
				<i class="small-text">Окончание: </i>&nbsp;<span style="font-weight: bold;"><?= $model['stop'] ? $model['stop'] : 'не указано' ?></span></br>
			</div>
		</div>

	</div>
</div>