<?php
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\widgets\Avatar;
use common\widgets\Arrays;

/* @var $this yii\web\View */
/* @var $model common\models\letters\Letters */
$ses = Yii::$app->session;
$ses->open();

$parent_cat = $ses->get('parent_cat');
$first_child = $ses->get('first_child');
$ses->close();

$cur_cat = $model['cat'];

if (!empty($model['m_description'])) {
	$this->registerMetaTag(['content' => Html::encode($model['m_description']), 'name' => 'description']);
}
if (!empty($model['m_keyword'])) {
	$this->registerMetaTag(['content' => Html::encode($model['m_keyword']), 'name' => 'keywords']);
}
$this->params['right'] = true;
$this->params['left'] = true;
$this->title = $model['title'];
$this->params['breadcrumbs'][] = ['label' => 'Коллективные письма', 'url' => [Url::to('/letters/letters/index')]];
if (!empty($parent_cat)) {
	foreach ($parent_cat as $cat) {
		$this->params['breadcrumbs'][] = ['label' => $cat['name'], 'url' => [Url::to('/letters/letters/index'), 'cat' => $cat['alias']]];
	}
}
$this->params['breadcrumbs'][] = ['label' => $cur_cat['name'], 'url' => [Url::to('/letters/letters/index'), 'cat' => $cur_cat['alias']]];
$this->params['breadcrumbs'][] = $this->title;
$user = Yii::$app->user->getIdentity();
$this->params['letter_alias'] = $model['alias'];
$this->params['letter_id'] = $model['id'];
?>
	<div class="letters-view">
		<div class="row">
			<div class="col-sm-12">
				<h1><strong style="font-size: 0.9em; font-style: italic;"><?= $model['title'] ?></strong></h1>

				<p><i class="small-text">Дата письма:&nbsp;<?= \Yii::$app->formatter->asDate($model['updated_at'], 'long') ?></i>
					&nbsp;&nbsp;&nbsp;<i class="small-text">Статус письма:&nbsp;</i><strong><?= Arrays::getLetterStage($model['stage']) ?></strong>
					<?= $model['author'] ? '&nbsp;&nbsp;&nbsp;<i class="small-text">Автор:&nbsp;</i>' . $model['author'] : '' ?>

				</p>
<?php if (Yii::$app->user->isGuest) : ?>
	<div class="tag-box tag-box-v4 margin-bottom-10">
		<h4>Для голосования Вам необходимо войти на сайт, либо зарегистрироваться, если еще не регистрировались.</h4>
		<p><?= Html::a('Войти', ['/site/login'], ['class' => 'btn-u']) ?> <?= Html::a('Зарегистрироваться', ['/site/signup'], ['class' => 'btn-u btn-brd']) ?></p>
	</div>
<?php ELSE : ?>
				<div class="service-block service-block-u rating-block">
					<?php if ($model['stage'] != 2) { ?>
						<span style="font-size: 1.2em;">Голосуем за письмо&nbsp;</span><span id="message_<?= $model['id'] ?>"></span>
						<table width="300px" style="margin: 3px auto;">
							<tr>
								<td width="50%">
									<button id="rating_up_<?= $model['id'] ?>" onclick="rating_up(<?= $model['id'] ?>)" class="rating_btn_up btn-u btn-brd rounded btn-u-default btn-u-xs" style="width: 100%;">
										<i class="fa fa-thumbs-o-up" style="margin-right: 0px;"></i>&nbsp;&nbsp; ЗА &nbsp;&nbsp; <i id="vote_yes_<?= $model['id'] ?>"><?= $model['vote_yes'] ?></i>
									</button>
								</td>
								<td width="50%">
									<button id="rating_down_<?= $model['id'] ?>" onclick="rating_down(<?= $model['id'] ?>)" class="rating_btn_down btn-u btn-brd rounded btn-u-default btn-u-xs" style="width: 100%;">
										<i class="fa fa-thumbs-o-down" style="margin-right: 0px;"></i>&nbsp;&nbsp; ПРОТИВ &nbsp;&nbsp; <i id="vote_no_<?= $model['id'] ?>"><?= $model['vote_no'] ?></i>
									</button>
								</td>
							</tr>
						</table>
					<?php } ?>
					<span id="id_rating_txt_<?= $model['id'] ?>" class="rating-val">
                        <i> Текущий рейтинг: </i>&nbsp;<strong id="rating_val_<?= $model['id'] ?>"><?= Yii::$app->formatter->asText($model['rating']) ?></strong>&nbsp;&nbsp;
                    </span>
				</div>
<?php ENDIF ?>
				<p><strong><?= $model['subtitle'] != '' ? $model['subtitle'] : '' ?></strong></p>
			</div>
		</div>
		<hr style="margin: 0px 0px 15px 0px; border: 2px solid #ddd;">
		<div class="row">
			<div class="col-sm-12">
				<div><?= $model['text'] ?></div>
			</div>
		</div>
		<?php if ($model['stage'] == 2) { ?>
			<hr style="margin: 0px 0px 15px 0px; border: 2px solid #ddd;">
			<h2>Полученный ответ на письмо:</h2>
			<div class="row">
				<div class="col-sm-12">
					<div><?= $model['answer'] ?></div>
				</div>
			</div>
		<?php } ?>
		<div class="row">

			<div class="container-fluid">
				<h4 style="margin: 15px 0px 0px 0px;">Комментарии</h4>
				<?php if (!Yii::$app->user->isGuest) {
					$comment = new \common\models\letters\LettersComments();
					?>
					<?= $this->render('_addComment', [
						'model' => $comment
					]); ?>
				<?php } else { ?>
					<h6>Зарегистрируйтесь или войдите на сайт, чтобы оставлять комментарии.</h6>
				<?php } ?>
				<?= $this->render('_comments', [
					'model' => $model,
					'dataProvider' => $dataProvider,
				]); ?>
			</div>
		</div>

	</div>
<?php
$this->registerJsFile('/js/ajax/letters.js', ['depends' => [\yii\web\YiiAsset::className()]]);
?>
