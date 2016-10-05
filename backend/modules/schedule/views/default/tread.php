<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User: Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 27.09.2016
 * Time: 14:13
 */

$date = Yii::$app->request->get('date');
if ( empty($date) ) {
	$date = date('Y-m-d');
}
?>
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">
			<i>№ поезда: </i> <strong><?= $list[ '363Э' ] ?></strong> - <i> <i>Маршрут: </i> <strong><?= $list[ 'title' ] ?></strong> - <i> На дату:</i> <?= Yii::$app->formatter->asDate($date) ?>
		</h3>
	</div>
	<div class="panel-body">
		<?php
		if ( !empty($list[ 'stops' ]) ) { ?>
			<table class="table table-condensed">
				<thead>
				<tr>
					<th class="width-100">Тип станции</th>
					<th class="width-250">Станция</th>
					<th class="width-100">Прибытие</th>
					<th class="width-100">Отбытие</th>
					<th class="width-100">Стоянка (мин)</th>
				</tr>
				</thead>
				<?php foreach ( $list[ 'stops' ] as $sch ) {
					if(!empty($sch[ 'arrival' ])){
						$arrival = new DateTime($sch[ 'arrival' ]);
						$arrival = $arrival->format('H:i');
					}else{
						$arrival = ' - ';
					}
					if(!empty($sch[ 'departure' ])){
						$departure= new DateTime($sch[ 'departure' ]);
						$departure = $departure->format('H:i');
					}else{
						$departure = ' - ';
					}
					if(!empty($sch[ 'stop_time' ]) && $sch[ 'stop_time' ] != 0){
						$stop_time = $sch[ 'stop_time' ] / 60;
					}else{
						$stop_time = ' - ';
					}
					?>
					<tr>
						<td><?= $sch['station'][ 'station_type' ]?></td>
						<td><?= $sch['station'][ 'title' ] ?></td>
						<td><?= $arrival ?></td>
						<td><?= $departure ?></td>
						<td><?= $stop_time ?></td>
					</tr>
				<?php } ?>
			</table>
			<?php
		} else {
			echo '<h2>Данные отсутствуют</h2>';
		} ?>
	</div>
</div>
