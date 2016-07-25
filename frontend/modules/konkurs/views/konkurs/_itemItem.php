<?php

use yii\helpers\Html;
use \yii\helpers\Url;
use \yii\bootstrap\Modal;
use kartik\widgets\StarRating;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

/* @var $konkurs common\models\konkurs\Konkurs */
/* @var $model common\models\konkurs\KonkursItem */

if (Yii::$app->user->isGuest) {
	$vote = 0;
} else {
	if (Yii::$app->user->id == $model['vote']['id_user'] && !empty($model['vote']['scope'])) {
		$vote = $model['vote']['scope'];
	} else {
		$vote = 0;
	}
}
if($konkurs->show_img){
	$desc =  \common\helpers\Functions::subString($model->description, 120);
}else{
	$desc =  \common\helpers\Functions::subString($model->description, 400);
}


?>

<div class="item">
	<div class="col-md-6">
		<div class="thumbnails thumbnail-style">
			<div class="for-one-height">
				<div class="thumbnail-img">
					<div class="overflow-hidden">
						<div class="star-block">
							<?= StarRating::widget([
							'name' => 'rating',
							'value' => $model['scope'],
							'pluginOptions' => [
								'language' => 'ru',
								'size' => 'xxs',
								'stars' => 5,
								'min' => 0,
								'max' => 5,
								'step' => 0.1,
								//'filledStar' => '<span class="krajee-icon krajee-icon-star"></span>',
								//'emptyStar' => '<span class="krajee-icon krajee-icon-star"></span>',
								'displayOnly' => true,
								'showClear' => false,
								]
							]);?>
						</div>
						<?php if($konkurs->show_img): ?>
							<?= \common\helpers\Thumb::imgWithOptions($model['base_url'], $model['img'], ['id' => 'img_id_' . $model['id'], 'style' => 'width: 100%; overflow: hidden;']) ?>
						<?php ENDIF; ?>
					</div>
					<?= Html::a('Подробнее',['/konkurs/item/item', 'cat' => $konkurs['cat']['slug'], 'konkurs'=>$konkurs['slug'], 'id'=>$model['id']],['class' => 'btn btn-more hover-effect']); ?>
					<?php Modal::begin([
						'header' => Html::tag('h3', '<i>Конкурс: </i>' . $model['konkurs']['name']),
						'toggleButton' => [
							'tag' => 'button',
							'class' => 'btn btn-more hover-effect',
							'label' => 'Голосовать',
						],
					]); ?>
					<h4><i>Название: </i><?= $model['name'] ?></h4>
					<?php if($konkurs->show_img): ?>
						<?= \common\helpers\Thumb::imgWithOptions($model['base_url'], $model['img'], ['id' => 'img_id_' . $model['id'], 'style' => 'width: 100%; overflow: hidden;']) ?>
					<?php ENDIF; ?>
					<?php if($konkurs->show_des):?>
						<p>
							<?= nl2br($desc); ?>
						</p>
					<?php ENDIF; ?>
					<?php $form = ActiveForm::begin(); ?>
					<p>
						<i>Добавил участник: </i><strong><?= Html::a($model['user']['username'], ['/konkurs/konkurs/view', 'cat'=>$konkurs['cat']['slug'], 'id'=>$konkurs['slug'], 'user'=>$model['id_user']]) ?></strong>&nbsp;&nbsp;
						<i>Дата фото: </i><strong><?= $model['created_at'] ? Yii::$app->formatter->asDate($model['created_at']) : 'не указана' ?></strong><br>
						<i>Проголосовало: </i><strong><?= !empty($model['vote_count']) ? $model['vote_count'] .' (чел.) ' : 'еще нет голосов' ?></strong>&nbsp;&nbsp;
						<i>Средний балл: </i><strong><?= !empty($model['scope']) ? $model['scope'] : 'еще нет голосов' ?></strong>
					</p>
					<p>
						<?php if (Yii::$app->user->isGuest) { ?>
						<div class="tag-box tag-box-v4 margin-bottom-40">
							<h2>Для голосования Вам необходимо войти на сайт, либо зарегистрироваться, если еще не регистрировались.</h2>
							<p><?= Html::a('Войти',['/site/login'],['class'=>'btn-u']) ?> <?= Html::a('Зарегистрироваться',['/site/signup'],['class'=>'btn-u btn-brd']) ?></p>
						</div>
						<?php } else {
							echo StarRating::widget([
								'name' => 'rating',
								'value' => $vote,
								'language' => 'ru',
								'pluginOptions' => [
									'stars' => 5,
									'min' => 0,
									'max' => 5,
									'step' => 0.1,
									'defaultCaption' => '{rating} лайков',
									'starCaptions' => new JsExpression("function(val){
												var text = '';
												if(val == 1){
													text = 'Звезда';
												}else if(val >= 5){
													text = 'Звезд';
												}else{
													text = 'Звезды';
												}
												return val + ' ' + text;
											}"),
									'clearButtonTitle'=> 'Удалить свой голос',
									'clearCaption'=> 'Вы не голосовали',
								]
							]);
							echo Html::hiddenInput('user_id', $model['id_user']);
							echo Html::submitButton('Готово', ['name' => 'item', 'value' => $model['id'], 'class' => 'btn-u btn-block']);
						}
						?>
					</p>
				<?php ActiveForm::end(); ?>
				<?php Modal::end(); ?>
				<?php if(!$konkurs->show_img): ?>
					<br><br><br><br>
				<?php ENDIF; ?>
			</div>
		</div>
		<div class="caption">

			<h3><?= $model->name; ?></h3>
			<?php if($konkurs->show_des): ?>
				<p>
					<?= nl2br($desc); ?>
				</p>
			<?php ENDIF; ?>
			<p>
				<i>Добавил участник: </i><strong><?= Html::a($model['user']['username'], ['/konkurs/konkurs/view', 'cat'=>$konkurs['cat']['slug'], 'id'=>$konkurs['slug'], 'user'=>$model['id_user']]) ?></strong>&nbsp;&nbsp;
				<i>Дата фото: </i><strong><?= $model['created_at'] ? Yii::$app->formatter->asDate($model['created_at']) : 'не указана' ?></strong>&nbsp;&nbsp;<br>
				<i>Проголосовало: </i><strong><?= !empty($model['vote_count']) ? $model['vote_count'] .' (чел.) ' : '0 (чел.)' ?></strong>&nbsp;&nbsp;
				<i>Средний балл: </i><strong><?= !empty($model['scope']) ? $model['scope'] : 'еще нет голосов' ?></strong><br>
			</p>
		</div>
	</div>
</div>
</div>
