<?php
$schedule = new \common\models\schedule\Schedule();
$date = Yii::$app->request->get('date');
if ( empty($date) ) {
	$date = date('Y-m-d');
}

?>

<div class="schedule-default-index">
	<h1>ЖД Расписание </h1>

	<p>
		<?= $this->render('_search'); ?>
	</p>

	<?php
	if ( !empty($list[ 'stations' ]) ) {
		foreach ( $list[ 'stations' ] as $station ) {
			?>
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">
						<i>Станция: </i> <strong><?= $station[ 'title' ] ?></strong> - <i> На дату:</i> <?= Yii::$app->formatter->asDate($date) ?>
					</h3>
				</div>
				<div class="panel-body">
					<table class="table table-condensed">
						<thead>
						<tr>
							<th class="width-100">№ рейса</th>
							<th class="width-100">Прилет</th>
							<th class="width-100">Вылет</th>
							<th class="width-250">Направление</th>
							<th>Дни курсирования</th>
						</tr>
						</thead>
						<?php
						$stat = $schedule->setRequest($station[ 'code' ], $date, 'plane');
						$stat = json_decode($stat, true);
						if ( !empty($stat[ 'schedule' ]) ) {
							foreach ( $stat[ 'schedule' ] as $sch ) {
								$arrival = new DateTime($sch[ 'arrival' ]);
								$departure = new DateTime($sch[ 'departure' ]);
								?>
								<tr>
									<td><?= $sch[ 'thread' ][ 'number' ] ?></td>
									<td><?= $arrival->format('H:i') ?></td>
									<td><?= $departure->format('H:i') ?></td>
									<td><?= $sch[ 'thread' ][ 'title' ] ?></td>
									<td><?= $sch[ 'days' ] ?></td>
								</tr>
							<?php }

						} else {
							echo '<h2>Данные отсутствуют</h2>';
						} ?>
					</table>
				</div>
			</div>
		<?php }
	} else { ?>
		<h2>Нет данных для отображения</h2>
	<?php } ?>
	<pre>
        <?php print_r($list); ?>
    </pre>
    <pre>
        <?php // print_r(json_decode($url, true)); ?>
    </pre>
</div>
<?php
$css = <<<CSS
.width-100{
	width: 100px;
}
.width-250{
	width: 250px;
}
CSS;

$this->registerCss($css);
?>
