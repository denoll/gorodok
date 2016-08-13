<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\DetailView;
	use yii\web\View;
	use yii\widgets\ActiveForm;
	/* @var $this yii\web\View */
	/* @var $model app\modules\menu\models\Menu */
	$this->title = $model_list->title . ' элементы';
	$this->params['breadcrumbs'][] = ['label' => 'Все меню', 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;


	function view_menu($menu)
	{
		if(empty($menu)) return null;
		foreach ($menu as $item) {
			echo '<li class="dd-item" data-id="' . $item['id'] . '"">';
			echo '<div class="dd-handle"> ' . $item['title'];

			echo '</div>';
			if ($item['children']) {
				echo '<ol class="dd-list">';
					view_menu($item['children']);
				echo '</ol>';
			}
			echo '</li>';
		}
	}

?>
<div class="menu-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<div class="row">
		<div class="col-lg-6">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Пункты меню: &nbsp;<?= $model_list->title ?>&nbsp;&nbsp;&nbsp;
						<?= \yii\bootstrap\Modal::widget([
							'id' => 'menu-create2',
							'toggleButton' => [
								'label' => '<i class="fa fa-plus"></i>&nbsp;Добавить новый пункт меню',
								'title' => 'Редактировать',
								'class' => 'btn btn-xs btn-primary',
								'tag' => 'a',
								'data-target' => '#menu-create2',
								'href' => Url::to(['/menu/menu-list/item-create', 'id' => $model_list->id]),
							],
							'clientOptions' => false,
						]);
						?>
					</h5>
				</div>
				<div class="ibox-content">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Редактировавть</th><th>Пункт</th><th>Порядок</th><th>Статус</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($model as $item){
								$url = '/menu/menu-list/item-edit'; ?>
								<tr>
									<td>
										<?=
											\yii\bootstrap\Modal::widget([
												'id' => 'menu-edit_' . $item['id'],
												'toggleButton' => [
													'label' => '<i class="fa fa-edit"></i>',
													'title' => 'Редактировать',
													'class' => 'btn btn-xs btn-primary',
													'tag' => 'a',
													'data-target' => '#menu-edit_' . $item['id'],
													'href' => Url::to([$url, 'id' => $item['id']]),
												],
												'clientOptions' => false,
											]);
										 ?>
									</td>
									<td>
										<?=$item['title']?>
									</td>
									<td>
										<?=$item['order']?>
									</td>
									<td>
										<?= $item['status'] == 1 ? 'Активный' : 'Не активный' ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Пункты меню: &nbsp;<?= $model_list->title ?></h5>
				</div>
				<div class="ibox-content">

					<p class="m-b-lg">
						<strong><?= $model_list->title ?></strong>
					</p>

					<div class="dd" id="nestable">
						<ol class="dd-list">
							<?php view_menu($menu); ?>
						</ol>
					</div>
					<div class="m-t-md">
						<h5>Serialised Output</h5>
					</div>
					<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
					<textarea id="nestable-output" name="items" class="form-control"></textarea>
					<div class="form-group">
						<?//= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
					</div>
					<?php ActiveForm::end(); ?>
				</div>
			</div>
		</div>
	</div>

</div>

<?php

$js = <<<JS
$("document").ready(function(){
			var updateOutput = function (e) {
			var list = e.length ? e : $(e.target),
				output = list.data("output");
			if (window.JSON) {
				output.val(window.JSON.stringify(list.nestable("serialize")));//, null, 2));
			} else {
				output.val("JSON browser support required for this demo.");
			}
		};
		// activate Nestable for list 1
		$("#nestable").nestable({
	       group: 1
		}).on("change", updateOutput);

var out;
		// output initial serialised data
		updateOutput($("#nestable").data("output", $("#nestable-output")));


		$("#nestable-menu").on("click", function (e) {
			var target = $(e.target),
				action = target.data("action");
			if (action === "expand-all") {
				$(".dd").nestable("expandAll");
			}
			if (action === "collapse-all") {
				$(".dd").nestable("collapseAll");
			}
		});
        });
JS;


	$this->registerJsFile('js/plugins/nestable/jquery.nestable.js', ['depends' => [\yii\web\YiiAsset::className()]]);
	$this->registerJs($js, View::POS_END);
?>
