<?php
	use backend\assets\AppAsset;
	use yii\helpers\Html;

	/* @var $this \yii\web\View */
	/* @var $content string */

	//dmstr\web\AdminLteAsset::register($this);
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
<body class="gray-bg">

<?php $this->beginBody() ?>
<div class="middle-box text-center loginscreen animated fadeInDown">
	<?= $content ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
