<?php
/**
 * Created by denoll.
 * User: denoll
 * Date: 29.06.2016
 * Time: 0:20
 */

use yii\widgets\ActiveForm;
use \Yii;
use yii\bootstrap\Html;
use yii\base\InvalidConfigException;
use yii\base\InvalidValueException;
use yii\helpers\Url;

if ($sheetData) {
	foreach ($sheetData[1] as $k => $first_row) {
		$columns[$k]['id'] = $k;
		$columns[$k]['name'] = $first_row;
	}
}
$this->title = 'Импорт фирм';
$this->params['breadcrumbs'][] = ['label' => 'Все фирмы', 'url' => ['/firm/firm/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
	<?= \yii\bootstrap\Modal::widget([
		'header' => '<h4>Импорт фирм</h4>',
		'id' => 'import-xls',
		'toggleButton' => [
			'label' => '<i class="fa-fw fa fa-download" style="margin-right: 3px;"></i>Загрузка файла <i><strong>Excel (*.xls)</strong></i> с фирмами',
			'class' => 'btn btn-success',
			'style' => 'width: 25%; font-size: 0.9em; color: #fff; padding: 5px 7px 5px 7px; text-align:center',
			'tag' => 'a',
			'data-target' => '#import-xls',
			'href' => '/firm/import/import-xls',
		],
		'clientOptions' => false,
	]); ?>
	<?= Html::a('Удалить все фирмы', ['/firm/import/delete'], [
		'class' => 'btn btn-danger',
		'data' => [
			'confirm' => 'Вы действительно хотите удалить все фирмы с сайта?',
			'method' => 'post',
		],
	]) ?>
</p>
<?php if ($sheetData) { ?>
	<div class="row">
		<div class="box box-widget">
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
			<div class="box-header with-border" style="background-color: #ccc; padding: 15px;">
				<div style="width: 900px; margin: 10px auto;">
					<h5>Обязательно сопоставьте колонки из таблицы загруженного файла Excel (названия колонок находятся в выпадающих списках), </h5>
					<h5>с полями фирм на сайте (названия полей расположены над выпадающими списками, и выделены жирным шрифтом).</h5>
				</div>
			</div>
			<br>

			<div class="box-body">
				<div class="col-md-4">
					<div class="form-group">
						<label>Категория</label>
						<?= Html::dropDownList('col[cat]', $col['cat'], \yii\helpers\ArrayHelper::map($columns, 'id', 'name'), ['class' => 'form-control', 'prompt'=>'Выберите колонку...']) ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Название</label>
						<?= Html::dropDownList('col[name]', $col['name'], \yii\helpers\ArrayHelper::map($columns, 'id', 'name'), ['class' => 'form-control', 'prompt'=>'Выберите колонку...']) ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Адрес</label>
						<?= Html::dropDownList('col[address]', $col['address'], \yii\helpers\ArrayHelper::map($columns, 'id', 'name'), ['class' => 'form-control', 'prompt'=>'Выберите колонку...']) ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Телефон</label>
						<?= Html::dropDownList('col[tel]', $col['tel'], \yii\helpers\ArrayHelper::map($columns, 'id', 'name'), ['class' => 'form-control', 'prompt'=>'Выберите колонку...']) ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Сайт</label>
						<?= Html::dropDownList('col[site]', $col['site'], \yii\helpers\ArrayHelper::map($columns, 'id', 'name'), ['class' => 'form-control', 'prompt'=>'Выберите колонку...']) ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Описание</label>
						<?= Html::dropDownList('col[description]', $col['description'], \yii\helpers\ArrayHelper::map($columns, 'id', 'name'), ['class' => 'form-control', 'prompt'=>'Выберите колонку...']) ?>
					</div>
				</div>
				<div class="col-md-12">
					<button class="btn btn-info btn-sm" type="submit"><i class="fa fa-tasks"></i> &nbsp; Загрузить список на сайт</button>
				</div>
			</div>
			<?php ActiveForm::end() ?>
		</div>
	</div>
<?php } ?>
<br>

<div class="table-responsive">
	<?php $count_row = count($sheetData) ?>
	<h4>Полученный файл: ( <?= $count_row - 1 ?> ) строк.</h4>
	<?php if ($sheetData) {
		array_splice($sheetData, 50) ?>
		<table class="table table-bordered table-hover dataTable" role="grid">
			<thead>
			<th>№</th>
			<?php foreach ($sheetData[0] as $first_row) { ?>
				<th role="row">
					<strong><?= $first_row ?></strong>
				</th>
			<?php } ?>
			</thead>
			<tbody>

			<?php foreach ($sheetData as $k => $row) { ?>
				<?php
				if ($k == 0) {
					continue;
				}
				//if($row[$col['email']]=='' && $row[$col['tel']] == ''){continue;}
				?>

				<tr>
					<td><?= $k - 1 ?></td>
					<?php foreach ($row as $cel) { ?>
						<td><?= $cel ?></td>
					<?php } ?>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	<?php } else { ?>
		<h3>Пока файл не загружен</h3>
	<?php } ?>
</div>


<pre>
	<? //=print_r($sheetData)?>
</pre>