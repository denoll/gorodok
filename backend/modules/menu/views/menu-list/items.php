<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\DetailView;
	use yii\web\View;
	use yii\widgets\ActiveForm;
	/* @var $this yii\web\View */
	/* @var $model app\modules\menu\models\Menu */
	$this->title = $model_list->title . ' элементы';
	$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;


	function view_menu($menu)
	{
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
					<h5>Пункты меню: &nbsp;<?= $model_list->title ?></h5>
				</div>
				<div class="ibox-content">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Редактировавть</th><th>Пункт</th><th>Статус</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($model as $item){
								$url = '/menu/menu-list/item-edit'; ?>
								<tr>
									<td>
										<?= Html::a('<i class="fa fa-edit"></i>',[$url,'id'=>$item['id']],['class' => 'btn btn-xs btn-primary','style' => 'margin-right: 10px;']) ?>
									</td>
									<td>
										<?=$item['title']?>
									</td>
									<td>
										<?= $item['status'] == 1 ? 'Активный' : 'Не активный' ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>

					<pre><?php print_r($new_order); ?></pre>

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
						<strong><?= $model_list->title ?></strong> Для изменения положения пункта меню переместите пункт в нужное место.
					</p>

					<div class="dd" id="nestable">
						<ol class="dd-list">
							<?php view_menu($menu); ?>
						</ol>
					</div>
					<div class="m-t-md">
						<h5>Serialised Output</h5>
					</div>
					<pre><?php print_r($post); ?></pre>
					<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
					<textarea id="nestable-output" name="items" class="form-control"></textarea>
					<div class="form-group">
						<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
					</div>
					<?php ActiveForm::end(); ?>
				</div>
			</div>
		</div>
	</div>

</div>

<?php



	$this->registerJsFile('js/plugins/nestable/jquery.nestable.js', ['depends' => [\yii\web\YiiAsset::className()]]);
	$this->registerJs(
		'$("document").ready(function(){
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
        });'
		, View::POS_END
	);
?>
