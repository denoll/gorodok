<?php

	use yii\helpers\Html;
	use yii\helpers\Url;

$this->params['right'] = true;
$this->params['left'] = true;
	$meta = [
		'm_keyword'=>'Форум городского портала Наша Тында',
		'm_description'=>'Форум городского портала Наша Тында',
	];

	$this->title = 'Форум городского портала Наша Тында';

	if (!empty($meta['m_description'])) {
		$this->registerMetaTag(['content' => Html::encode($meta['m_description']), 'name' => 'description']);
	}
	if (!empty($meta['m_keyword'])) {
		$this->registerMetaTag(['content' => Html::encode($meta['m_keyword']), 'name' => 'keywords']);
	}

	$this->params['breadcrumbs'][] = $this->title;

	$path = Url::home() . 'forum/category?id=';

?>

<div class="forum-default-index">
	<?php foreach ($forums as $forum) { ?>
	<div class="panel panel-u">
		<div class="panel-heading">
			<h3  class="panel-title" style="color: #fff;"><i class="fa fa-tasks"></i><?= $forum->name ?></h3>
		</div>
		<div class="panel-body">
			<i style="font-size: 1.1em;"> <?= $forum->description ?> </i>
			<hr style="margin: 0px 0px 10px 0px; border: none; border-bottom: 1px solid #c6c6c6;">
			<i class="small-text">Категории: </i>
			<ul class="list-inline">
				<?php foreach ($forum->forumCatsFront as $fc) { ?>
						<li style="padding: 0px;">
							<a class="btn-u btn-u-sm btn-u-dark" href="<?= $path . $fc->alias ?>" style="margin-bottom: 3px;">
									<?= $fc->name ?>&nbsp;&nbsp;
								<span class="badge badge-purple rounded" style="color: #fff; margin: 2px 0px;">
									<i style="font-size: 0.9em;">Кол-во тем (<?= $fc->count_theme ?>)</i>
								</span>
							</a>
						</li>
				<?php } ?>
			</ul>
		</div>
	</div>

	<?php } ?>

</div>
