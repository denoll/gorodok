<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User:  Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 11.07.2016
 * Time: 1:55
 */

use yii\helpers\Html;
use kartik\widgets\StarRating;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;
use \common\models\konkurs\KonkursItem;

/* @var $this yii\web\View */
/* @var $model common\models\konkurs\KonkursItem */
/* @var $konkurs common\models\konkurs\Konkurs */

$this->params['left'] = true;
$this->params['right'] = true;
Yii::$app->session->remove('id_konkurs');
Yii::$app->session->set('id_konkurs', $model->id_konkurs);
$this->title = 'Конкурс: ' . $konkurs->name . '. Элемент - ' . $model->name;
$mk = [
	$konkurs->cat->name,
	$konkurs->name,
	$model->name,
];
$md = [
	$konkurs->cat->name,
	$konkurs->name,
	$model->name,
];

$this->params['breadcrumbs'][] = ['label' => 'Все конкурсы', 'url' => ['/konkurs/konkurs/index']];
if(!empty($konkurs->cat)){
	$this->params['breadcrumbs'][] = ['label' => $konkurs->cat->name, 'url' => ['/konkurs/konkurs/index', 'cat'=>$konkurs->cat->slug]];
}
$this->params['breadcrumbs'][] = ['label' => $model->konkurs->name, 'url' => ['/konkurs/konkurs/view', 'cat'=>$konkurs->cat->slug, 'id' => $model->konkurs->slug]];
$this->params['breadcrumbs'][] = $model->name;

if (!empty($md)) {
	$this->registerMetaTag(['content' => implode(' ',$md), 'name' => 'description']);
}
if (!empty($mk)) {
	$this->registerMetaTag(['content' => implode(', ',$mk), 'name' => 'keywords']);
}


if (Yii::$app->user->isGuest) {
	$vote = 0;
} else {
	if (Yii::$app->user->id == $model['vote']['id_user'] && !empty($model['vote']['scope'])) {
		$vote = $model['vote']['scope'];
	} else {
		$vote = 0;
	}
}
?>
<div class="konkurs-item-view post">
	<h1 class="header-title"><?= $this->title ?></h1>
	<?php if (Yii::$app->user->isGuest) : ?>
		<div class="tag-box tag-box-v4 margin-bottom-10">
			<h4>Для голосования Вам необходимо войти на сайт, либо зарегистрироваться, если еще не регистрировались.</h4>
			<p><?= Html::a('Войти', ['/site/login'], ['class' => 'btn-u']) ?> <?= Html::a('Зарегистрироваться', ['/site/signup'], ['class' => 'btn-u btn-brd']) ?></p>
		</div>
	<?php ELSE : ?>
		<?php
		ActiveForm::begin();
		echo '<table width="100%"> <tr>';
		echo '<td width="80%">';
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
				'clearButtonTitle' => 'Удалить свой голос',
				'clearCaption' => 'Вы не голосовали',
			]
		]);
		echo '</td>';
		echo '<td>';
		echo Html::submitButton('Проголосовать', ['name' => 'item', 'value' => $model['id'], 'class' => 'btn-u btn-block']);
		echo '</td>';
		echo '</table> </tr>';
		echo Html::hiddenInput('user_id', $model['id_user']);
		ActiveForm::end(); ?>
	<?php ENDIF ?>
	<?php if ($model->konkurs->show_img): ?>
		<?= \common\helpers\Thumb::imgWithOptions($model['base_url'], $model['img'], ['style' => 'width: 100%;']) ?>
	<?php ENDIF; ?>
	<div class="page-in">
		<ul class="list-inline posted-info">
			<li>Добавил участник: <strong><?= $model['user']['username'] ?></strong>&nbsp;&nbsp;</li>
			<li>Дата фото: <strong><?= $model['created_at'] ? Yii::$app->formatter->asDate($model['created_at']) : 'не указана' ?></strong>&nbsp;&nbsp;</li>
			<li>Проголосовало: <strong><?= !empty($model['vote_count']) ? $model['vote_count'] . ' (чел.) ' : 'еще нет голосов' ?></strong>&nbsp;&nbsp;</li>
			<li>Сумма баллов: <strong><?= !empty($model['sum']) ? $model['sum'] : 'еще нет голосов' ?></strong>&nbsp;&nbsp;</li>
			<li>Средний балл: <strong><?= !empty($model['scope']) ? $model['scope'] : 'еще нет голосов' ?></strong>&nbsp;&nbsp;</li>
			<?php if ($model->id_user === Yii::$app->user->id && $model->status === KonkursItem::STATUS_VERIFICATION): ?>
				<li><?= Html::a('<i class="fa fa-edit"></i>&nbsp;Редактировать', ['update', 'id' => $model->id], ['class' => 'btn-u btn-brd rounded-2x btn-u-xs']) ?></li>
			<?php ENDIF; ?>
		</ul>
		<h1><i>Название: </i><?= $model['name'] ?></h1>
		<p>
			<?php if (!empty($model->description) && $model->konkurs->show_des): ?>
		<h4 class="no-margin">Описание</h4>
		<?= $model->description; ?>
		<?php ENDIF; ?>
		</p>

	</div>

</div>
