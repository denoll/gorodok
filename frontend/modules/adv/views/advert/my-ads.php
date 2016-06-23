<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;
use yii\widgets\LinkPager;

$this->params['left'] = true;

$this->title = 'Мои рекламные баннеры';
$this->params['breadcrumbs'][] = ['label' => 'Мой профиль', 'url' => [Url::home() . 'profile/index']];
$this->params['breadcrumbs'][] = $this->title;

$pay = Arrays::PAYMENTS();
$period = Arrays::getConst();
?>

	<div class="jobs-default-index">
		<div class="panel panel-dark">
			<div class="panel-heading">
				<h1 class="panel-title" style="margin: 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
			</div>
			<div class="panel-body">
				<?= Html::a('<i class="fa fa-plus"></i>  Добавить рекламный баннер', ['/adv/advert/create'], ['class' => 'btn-u btn-u-dark']) ?>
				<?= LinkPager::widget([
					'pagination' => $pages,
				]); ?>
				<br><br>

				<?php $form = ActiveForm::begin(); ?>
				<div class="row">
					<div class="container-fluid s-results margin-bottom-50">
						<?php foreach ($model as $item) { ?>
							<div class="inner-results row">
								<div class="col-md-3"><?= Html::img($item['base_url'] . '/' . $item['path'], ['class' => 'thumbnail', 'style' => 'width: 100%;']) ?></div>
								<div class="col-md-6">
									<?= 'Статус баннера: <strong>' . \common\helpers\Arrays::getStatusBanner($item['status']) . '</strong>' ?><br>
									<?= 'Начало показа баннера: <strong>' . ($item['start']) . '</strong>' ?><br>
									<?php if ($item['stop']) { ?>
										<?= 'Окончание показа баннера: <strong>' . $item['stop'] . '</strong>' ?><br>
									<?php } ?>
									<i>Место показа баннера: </i><strong><?= $item['banner']['name'] ?></strong><br>
									<i>Рекламная компания баннера: </i><strong><?= $item['advert']['name'] ?></strong><br>
									<i>Кол-во дней показа: </i>(<strong><?= $item['day_count'] ?></strong>) <i>из</i> (<?= $item['max_day'] ? $item['max_day'] : 'Без ограничений'; ?>)<br>
									<i>Кол-во показов: </i>(<strong><?= $item['hit_count'] ?></strong>) <i>из</i> (<?= $item['max_hit'] ? $item['max_hit'] : 'Без ограничений'; ?>)<br>
									<i>Кол-во кликов: </i>(<strong><?= $item['click_count'] ?></strong>) <i>из</i> (<?= $item['max_click'] ? $item['max_click'] : 'Без ограничений'; ?>)<br>
								</div>
								<div class="col-md-2" style="margin: 5px 0px;">
									<?php
									echo Html::a('<i class="fa fa-eye"></i>&nbsp;Подробнее', ['/adv/advert/view', 'id' => $item['id']], ['class' => 'btn btn-sm btn-info btn-block']);
									echo Html::a('<i class="fa fa-trash"></i>&nbsp;Удалить', ['/adv/advert/delete', 'id' => $item['id']], ['class' => 'btn btn-sm  btn-danger btn-block', 'data' => [
										'confirm' => 'Вы действительно хотите удалить этот рекламный баннер?',
										'method' => 'post',
									]]);
									?>
								</div>
							</div>
							<hr>
						<?php } ?>
					</div>
				</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
