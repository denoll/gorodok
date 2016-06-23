<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \common\models\banners\BannerItem;

/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerItem */
$this->params['left'] = true;
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Мои рекламные баннеры', 'url' => ['my-ads']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="banner-item-view">
	<p>
		<?= Html::a('<i class="fa fa-trash"></i>&nbsp;Удалить', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => 'Вы действительно хотите удалить этот рекламный баннер?',
				'method' => 'post',
			],
		]) ?>
	</p>
	<div class="row">
		<?php if($model['status'] === BannerItem::STATUS_VERIFICATION){ ?>
		<div class="container-fluid">
			<div class="tag-box tag-box-v4">
				<h2>Внимание! Ваш рекламный баннер находится на стадии проверки.</h2>
				<p>
					После успешного проведения проверки, баннер будет размещен в указанной Вами позиции.<br>
					Просим заранее пополнить Ваш баланс, на сумму не меньшую стоимости одной рекламной компании.<br>
					Стоимость одной, выбранной Вами, рекламной компании составляет : <strong> <?= BannerItem::priceAdvert($model['advert']['id']) ?> руб. </strong>&nbsp;
					<?= Html::a('Пополнить баланс <i class="fa fa-ruble"></i>',['/account/pay'],['class'=>'btn-u btn-u-sm btn-u-default']) ?><br>
					<i>По всем вопросам просьба обращаться в администрацию сайта.</i>
				</p>
			</div>
		</div>
		<?php } ?>
		<div class="col-sm-3 side_left">
			<?= Html::img($model['base_url'] . '/' . $model['path'], ['class' => 'thumbnail img-responsive']) ?>
		</div>
		<div class="col-sm-9">
			<ul class="list-group">
				<li class="list-group-item"><?= 'Статус баннера: <strong>' . \common\helpers\Arrays::getStatusBanner($model['status']) . '</strong>' ?></li>
				<li class="list-group-item"><?= 'Начало показа баннера: <strong>' . ($model['start']) . '</strong>' ?></li>
				<?php if ($model['stop']) { ?>
					<li class="list-group-item"><?= 'Окончание показа баннера: <strong>' . $model['stop'] . '</strong>' ?></li>
				<?php } ?>
				<li class="list-group-item"><i>Место показа баннера: </i><strong><?= $model['banner']['name'] ?></strong></li>
				<li class="list-group-item"><i>Рекламная компания баннера: </i><strong><?= $model['advert']['name'] ?></strong></li>
			</ul>
		</div>
		<div class="container-fluid">
			<table class="table table-bordered">
				<thead>
				<tr><th colspan="4">Данные о рекламной компании</th></tr>
				<tr>
					<th></th><th>Дни</th><th>Показы</th><th>Переходы (клики)</th>
				</tr>

				</thead>
				<tbody>
				<tr>
					<td><strong>Ведется учет:</strong><sup>1</sup></td>
					<td><?= \common\helpers\Arrays::getYesNo($model['advert']['day_status']) ?></td>
					<td><?= \common\helpers\Arrays::getYesNo($model['advert']['hit_status']) ?></td>
					<td><?= \common\helpers\Arrays::getYesNo($model['advert']['click_status']) ?></td>
				</tr>
				<tr>
					<td><strong>Стоимость одного:</strong><sup>2</sup></td>
					<td><?= $model['advert']['day_price'] ?> руб/день.</td>
					<td><?= $model['advert']['hit_price'] ?> руб/показ.</td>
					<td><?= $model['advert']['click_price'] ?> руб/переход.</td>
				</tr>
				<tr>
					<td><strong>Списывать каждые:</strong><sup>3</sup></td>
					<td><?= $model['advert']['day_size'] ?> дней.</td>
					<td><?= $model['advert']['hit_size'] ?> показов</td>
					<td><?= $model['advert']['click_size'] ?> переходов</td>
				</tr>
				</tbody>
				<tfoot>
				<tr>
					<td colspan="4">
						<i>1 - По каким критериям ведется учет - по дням, по показам или по переходам(кликам).</i><br>
						<i>2 - Стоимость одного дня, показа, перехода. Денежные средства списываются с Вашего счета только, по тем критериям, по которым ведется учет.</i><br>
						<i>3 - Шаг списания средств с Вашего счета(баланса), если ведется учет.</i><br>
						<br>
						<hr class="no-margin">
						<i>Денежные средства списываются по формуле: <strong>Событие(показ, день, клик) * Стоимость * Шаг списания</strong></i><br>
						<i><strong>Показ</strong> - один показ рекламного баннера пользователю.</i><br>
						<i><strong>Переход</strong> (клик) - один переход по ссылке с рекламного баннера</i><br>
						<i><strong>День</strong> - один день размещения рекламного баннера, вне зависимости от кол-ва показов или переходов.</i><br>
					</td>
				</tr>
				</tfoot>

			</table>
			<table class="table table-bordered">
				<thead>
				<th></th>
				<th>Текущее кол-во</th>
				<th>Максимальное кол-во</th>
				</thead>
				<tbody>
				<tr>
					<td><strong>Кол-во дней показа:</strong></td>
					<td><?= $model['day_count'] ?></td>
					<td><?= $model['max_day'] ? $model['max_day'] : 'Без ограничений'; ?></td>
				</tr>
				<tr>
					<td><strong>Кол-во показов:</strong></td>
					<td><?= $model['hit_count'] ?></td>
					<td><?= $model['max_hit'] ? $model['max_hit'] : 'Без ограничений'; ?></td>
				</tr>
				<tr>
					<td><strong>Кол-во кликов:</strong></td>
					<td><?= $model['click_count'] ?></td>
					<td><?= $model['max_click'] ? $model['max_click'] : 'Без ограничений'; ?></td>
				</tr>
				</tbody>

			</table>
		</div>
	</div>
</div>
