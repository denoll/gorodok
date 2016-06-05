<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);

$this->registerMetaTag(['content' => Url::to('@frt_url/img/logo_2.png'), 'property' => 'og:image']);
$this->registerMetaTag(['content' => Url::to('@frt_url') . ' - ' . $this->title, 'property' => 'og:site_name']);

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
<body>
<?php $this->beginBody() ?>

<div class="wrapper">

	<div class="header-v4 header-sticky">

		<?= $this->render(
			'top.php',
			['directoryAsset' => $directoryAsset]
		) ?>


		<?= $this->render(
			'menu.php',
			['directoryAsset' => $directoryAsset]
		) ?>

	</div>

	<div class="container">
		<div class="row">
			<?php if (($this->params['left']) && (!$this->params['right'])) { //Если только левый блок и центр ?>
				<div class="col-md-3 side_left">
					<?= $this->render('left') ?>
				</div>
				<div class="col-md-9">
					<?= Breadcrumbs::widget([
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
					]) ?>

					<?= Alert::widget() ?>

					<br>
					<?= $content ?>


				</div>
			<?php } elseif (($this->params['left']) && ($this->params['right'])) { //Если левы правый блоки и центр ?>
				<div class="col-md-3 main_left side_left">
					<?= $this->render('left') ?>
				</div>
				<div class="col-md-6 main_center side_left">
					<?= Breadcrumbs::widget([
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
					]) ?>
					<?= Alert::widget() ?>
					<?= $content ?>
				</div>
				<div class="col-md-3 main_right">
					<?= $this->render('right') ?>
				</div>
			<?php } elseif ((!$this->params['left']) && ($this->params['right'])) { //Если только правый блок и центр ?>
				<div class="col-md-9 side_left">
					<?= Breadcrumbs::widget([
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
					]) ?>
					<?= Alert::widget() ?>
					<?= $content ?>
				</div>
				<div class="col-md-3">
					<?= $this->render('right') ?>
				</div>
			<?php } else { //Если только центр ?>
				<div class="col-md-12">
					<?= Breadcrumbs::widget([
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
					]) ?>
					<?= Alert::widget() ?>
					<?= $content ?>

				</div>
			<?php } ?>
		</div>
	</div>
	<footer class="footer">
		<?= $this->render(
			'footer.php',
			['directoryAsset' => $directoryAsset]
		) ?>
	</footer>
	<!-- Yandex.Metrika counter -->
	<script type="text/javascript">
		(function (d, w, c) {
			(w[c] = w[c] || []).push(function () {
				try {
					w.yaCounter35183035 = new Ya.Metrika({
						id: 35183035,
						clickmap: true,
						trackLinks: true,
						accurateTrackBounce: true,
						trackHash: true
					});
				} catch (e) {
				}
			});

			var n = d.getElementsByTagName("script")[0],
				s = d.createElement("script"),
				f = function () {
					n.parentNode.insertBefore(s, n);
				};
			s.type = "text/javascript";
			s.async = true;
			s.src = "https://mc.yandex.ru/metrika/watch.js";

			if (w.opera == "[object Opera]") {
				d.addEventListener("DOMContentLoaded", f, false);
			} else {
				f();
			}
		})(document, window, "yandex_metrika_callbacks");
	</script>
	<noscript>
		<div><img src="https://mc.yandex.ru/watch/35183035" style="position:absolute; left:-9999px;" alt=""/></div>
	</noscript>
	<!-- /Yandex.Metrika counter -->

	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
