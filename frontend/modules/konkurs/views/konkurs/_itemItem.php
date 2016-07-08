<?php
use yii\helpers\Html;
use \yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use frontend\widgets\Avatar;
use \common\widgets\Arrays;

?>
<div class="item">
	<div class="col-md-6">
		<div class="thumbnails thumbnail-style thumbnail-kenburn">
			<div class="thumbnail-img">
				<div class="overflow-hidden">
					<?= \common\helpers\Thumb::img($model['base_url'],$model['img'], '100%') ?>
				</div>
				<a class="btn-more hover-effect" href="#">Голосовать</a>
			</div>
			<div class="caption">
				<h3>
					Участник: <?= $model['user']['username'] ?>


				</h3>
				<p>
					<i>Добавил фото: </i><?= $model['created_at'] ? $model['created_at'] : 'не указано' ?>
					<?= $model['description']; ?>
				</p>
			</div>
		</div>
	</div>
</div>