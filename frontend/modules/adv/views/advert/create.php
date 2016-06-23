<?php
/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerItem */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\widgets\Arrays;
use common\models\banners\BannerItem;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use kartik\widgets\DateTimePicker;

$this->params['left'] = true;
$this->title = 'Создание нового рекламного баннера';
$this->params['breadcrumbs'][] = ['label' => 'Все рекламные баннеры', 'url' => ['my-ads']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="banner-item-create">


	<div class="banner-item-form">

		<?php $form = ActiveForm::begin(); //['options' => ['enctype' => 'multipart/form-data']] ?>
		<div class="row">
			<div class="col-md-12">
				<div class="tag-box tag-box-v4">
					<h2>Добавление рекламного баннера.</h2>
					<ol>
						<li>Выберите рекламную компанию в соответствии с Вашими желаниями и потребностью.</li>
						<li>Выберите место расположения рекламного баннера.</li>
						<li>Добавьте изображение рекламного баннера (Размеры изображения указаны в расположении баннера).</li>
						<li>Добавьте http ссылку баннера (ссылка - это http адрес сайта на который будет осуществлен переход после клика по баннеру).</li>
						<li>При необходимости укажите даты и время начала и окончания рекламной компании.</li>
						<li>Нажмите кнопку "Отправить на проверку".</li>
					</ol>
					<p>
						После проверки баннера, пополните Ваш баланс на соответствующую сумму. После проверки и пополнения баланса Ваш рекламный баннер появится на сайте.
					</p>
				</div>
			</div>
		</div>
		<?= $form->errorSummary($model) ?>

		<div class="row">
			<div class="col-md-6">
				<?= $form->field($model, 'id_adv_company')->dropDownList(ArrayHelper::map($advert, 'id', 'name')) ?>

				<?= $form->field($model, 'banner_key')->dropDownList(ArrayHelper::map($blocks, 'key', 'name')) ?>

				<?= $form->field($model, 'url')->textInput(['maxlength' => true, 'placeholder'=>'http://адрес ссылки с вашего баннера']) ?>

				<?= $form->field($model, 'start')->widget(DateTimePicker::classname(), [
					'options' => ['placeholder' => 'Укажите дату и время ...'],
					'value' => date('Y-m-d H:i:s'),
					'pluginOptions' => [
						'autoclose' => true,
					]
				]); ?>

				<?= $form->field($model, 'stop')->widget(DateTimePicker::classname(), [
					'options' => ['placeholder' => 'Укажите дату и время ...'],
					'pluginOptions' => [
						'autoclose' => true
					]
				]); ?>
			</div>
			<div class="col-md-4">
				<?= $form->field($model, 'files')->widget(
					'\denoll\filekit\widget\Upload',
					[
						'url' => ['upload'],
						'maxFileSize' => 1 * 1024 * 1024, // 1 MiB
						//'maxNumberOfFiles' => 1,
						'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
					]
				); ?>
				<br>
			</div>
		</div>
		<div class="form-group">
			<?= Html::submitButton('<i class="fa fa-paper-plane"></i>&nbsp;&nbsp;Отправить на проверку', ['class' => 'btn btn-success']) ?>
		</div>
		<div class="row">
			<div class="col-md-12">
				<hr>
			</div>
		</div>
		<?php ActiveForm::end(); ?>

	</div>
</div>
	<?php
	$js = <<<JS
	function delSession() {
	  $.ajax({
        type: "get",
        url: "del-session",
        cache: true,
        dataType: "html",
        success: function (data) {
			
           
        }
    });
	}
JS;

	$this->registerJs($js, \yii\web\View::POS_END);

	?>



