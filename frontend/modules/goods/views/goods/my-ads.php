<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;
use yii\widgets\LinkPager;

$this->params['left'] = true;

$this->title = 'Мои объявления о товарах';
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
				<?= Html::a('Мои товары', [Url::home() . 'goods/my-ads'], ['class' => 'btn-u btn-u-dark-blue']) ?>
				<?= Html::a('<i class="fa fa-plus"></i>  Добавить объявление о товаре', [Url::home() . 'goods/create'], ['class' => 'btn-u btn-u-dark']) ?>
				<?= LinkPager::widget([
					'pagination' => $pages,
				]); ?>
				<br><br>

				<?php $form = ActiveForm::begin(); ?>
				<div class="row">
					<div class="container-fluid s-results margin-bottom-50">
						<?php foreach ($model as $item) { ?>
							<div class="inner-results">
								<h3 style="margin:0px;"><?= Html::a($item['name'], [Url::home() . 'goods/view', 'id' => $item['id']], []) ?></h3>

								<div class="" style="margin: 5px 0px;">
									<?php
									if ($item['status'] == 0) {
										$status = 'style="display: none;"';
										$text = 'Сейчас объявление видно только мне';
									} else {
										$text = 'Сейчас объявление видно всем';
									}
									echo '<span ' . $status . ' onclick="changeUp(' . $item['id'] . ')" id="up-btn-' . $item['id'] . '" class="btn-u btn-u-sm btn-block btn-u-orange ads-btn" title="Поднять объявление на верх"><i class="fa fa-arrow-up"></i>&nbsp;&nbsp;Поднять объявление на верх (стоимость: ' . $pay['goods_up_pay'] . ' руб.)</span>';
									echo '<span ' . $status . ' onclick="changeVip(' . $item['id'] . ')" id="vip-btn-' . $item['id'] . '" class="btn-u btn-u-sm btn-block btn-u-dark-blue ads-btn" title="Выделить объявление  цветом"><i class="fa fa-trophy"></i>&nbsp;&nbsp;Выделить цветом сроком на ' . $period['vip'] . ' дней. <br>и поднять на верх (стоимость: ' . $pay['goods_vip_pay'] . ' руб.)</span>';
									echo '<span onclick="changeStatus(' . $item['id'] . ')" id="status-btn-' . $item['id'] . '" class="btn-u btn-u-sm  btn-u-green" title="Изменить статус на - Видно только мне">' . $text . '</span>';
									?>
									<?php
									echo Html::a('Редактировать', ['/goods/goods/update', 'id' => $item['id']], ['class' => 'btn-u btn-u-sm  btn-u-default']);
									echo Html::a('Удалить', ['/goods/goods/delete', 'id' => $item['id']], ['class' => 'btn-u btn-u-sm  btn-u-danger', 'data' => [
										'confirm' => 'Вы действительно хотите удалить это объявление?',
										'method' => 'post',
									]]);
									?>
								</div>
								<ul class="list-inline up-ul">
									<li>Цена: <strong><?= $item['cost'] != null ? number_format($item['cost'], 2, ',', "'") . ' руб.' : ' - не указана' ?></strong> ‎</li>
									<li>
										<i class="small-text">‎Дата объявления:</i>&nbsp;
										<?= Yii::$app->formatter->asDate($item['created_at'], 'long') ?>
									</li>
									<li>
                            <span>
                                <i class="small-text">‎Поднято на верх:</i>&nbsp;
                                <span id="span_updated_at_<?= $item['id'] ?>"><?= $item['updated_at'] != $item['created_at'] ? Yii::$app->formatter->asDate($item['updated_at'], 'long') : 'Объявление еще не поднимали' ?></span>
                            ‎</li>
									<li>
										<i class="small-text">Выделено:</i>&nbsp;
										<span id="span_vip_date_<?= $item['id'] ?>"><?= $item['vip_date'] != null ? Yii::$app->formatter->asDate($item['vip_date'], 'long') : 'Объявление еще не выделяли' ?></span>
										‎
									</li>
								</ul>

							</div>
							<hr>
						<?php } ?>
					</div>
				</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
<?php
$this->registerJsFile('/js/date.format.js', ['depends' => [\yii\web\YiiAsset::className()]]);
$this->registerJsFile('/js/ajax/goods.js', ['depends' => [\yii\web\YiiAsset::className()]]);
?>