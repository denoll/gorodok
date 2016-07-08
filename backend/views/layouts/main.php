<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);

if (Yii::$app->controller->action->id === 'login') {
	echo $this->render(
		'main-login',
		['content' => $content]
	);
} else {

	?>
	<?php $this->beginPage() ?>
	<!DOCTYPE html>
	<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?= Html::csrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
	</head>
	<body class="pace-done ">  <!-- For collapser left nav panel insert class - mini-navbar -->
	<?php $this->beginBody() ?>
	<div id="wrapper">
		<?= $this->render(
			'left.php',
			['directoryAsset' => $directoryAsset]
		) ?>

		<div id="page-wrapper" class="gray-bg">
			<?= $this->render(
				'top-menu.php',
				['directoryAsset' => $directoryAsset]
			) ?>

			<div class="wrapper wrapper-content"> <!--  animated fadeInRight -->
				<div class="row" style="margin-bottom: 30px;">
					<div class="container-fluid">
						<div style="margin-bottom: 10px; margin-top: 10px;">
							<?= Breadcrumbs::widget([
								'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
							]) ?>
						</div>
						<div style="margin-bottom: 5px;">
							<?= Alert::widget() ?>
						</div>
						<?= $content ?>
						<br>
					</div>
				</div>
			</div>
			<div class="footer">
				<div class="pull-right">
					Панель управления сайта.
				</div>
				<div>
					<strong>Copyright</strong> denoll company &copy; 2014-2015
				</div>
			</div>

		</div>
	</div>
	<?php $this->endBody() ?>
	</body>
	</html>
	<?php $this->endPage() ?>
<?php } ?>