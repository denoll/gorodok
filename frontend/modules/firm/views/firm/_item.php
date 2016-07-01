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
					<?= Html::a(Avatar::imgFirm($model['logo'], '100%'), ['/firm/firm/view', 'cat' => $model['cat']['slug'], 'id' => $model['id']]) ?>
				</div>
			</div>
			<div class="col-md-10 side_left">
				<h2 style="margin: 5px 0px;">
					<?= Html::a(Html::encode($model['name']), ['/firm/firm/view', 'cat' => $model['cat']['slug'], 'id' => $model['id']]) ?>
				</h2>
				<i class="small-text">Категория:&nbsp;</i><strong><?= Html::a($model['cat']['name'], [Url::to('/firm/firm/index'), 'cat' => $model['cat']['slug']]); ?></strong></br>
				<i class="small-text">Тел: </i>&nbsp;<span style="font-weight: bold;"><?= $model['tel'] ? $model['tel'] : 'не указан' ?></span></br>
				<i class="small-text">Сайт: </i>&nbsp;<span style="font-weight: bold;"><?= $model['site'] ? $model['site'] : 'не указан' ?></span>&nbsp;&nbsp;
				<i class="small-text">Email: </i>&nbsp;<span style="font-weight: bold;"><?= $model['email'] ? $model['email'] : 'не указан' ?></span></br>
				<i class="small-text">Адрес: </i>&nbsp;<span style="font-weight: bold;"><?= $model['address'] ? $model['address'] : 'не указан' ?></span></br>
			</div>
		</div>

	</div>
</div>