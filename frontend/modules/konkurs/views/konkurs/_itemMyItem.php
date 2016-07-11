<?php

use yii\helpers\Html;
use \yii\helpers\Url;
use \yii\bootstrap\Modal;
use kartik\widgets\StarRating;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

?>

<div class="item">
	<div class="col-md-6">
		<div class="thumbnails thumbnail-style">
			<div class="for-one-height">
				<div class="thumbnail-img">
					<div class="overflow-hidden">
						<?= \common\helpers\Thumb::imgWithOptions($model['base_url'], $model['img'], ['id' => 'img_id_' . $model['id'], 'style' => 'width: 100%; overflow: hidden;']) ?>
					</div>
					<?= Html::a('Подробнее',['/konkurs/item/item', 'id'=>$model['id']],['class' => 'btn btn-more hover-effect']); ?>
					<?= Html::a('Редактировать',['/konkurs/item/update', 'id'=>$model['id']],['class' => 'btn btn-more hover-effect']); ?>
			</div>
		</div>
		<div class="caption">
			<p>
				<i>Добавил участник: </i><strong><?= $model['user']['username'] ?></strong>&nbsp;&nbsp;
				<i>Дата фото: </i><strong><?= $model['created_at'] ? Yii::$app->formatter->asDate($model['created_at']) : 'не указана' ?></strong>&nbsp;&nbsp;<br>
				<i>Проголосовало: </i><strong><?= !empty($model['vote_count']) ? $model['vote_count'] .' (чел.) ' : '0 (чел.)' ?></strong>&nbsp;&nbsp;
				<i>Средний балл: </i><strong><?= !empty($model['scope']) ? $model['scope'] : 'еще нет голосов' ?></strong><br>
			</p>
		</div>
	</div>
</div>
</div>
