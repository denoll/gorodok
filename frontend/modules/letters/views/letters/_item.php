<?php
use yii\helpers\Html;
use \yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use frontend\widgets\Avatar;
use \common\widgets\Arrays;

?>
	<div class="item">
		<div class="margin-bottom-10">
			<div class="container-fluid" style="border: 1px solid #D9D9D9; padding: 1px; 10px; margin: 0px;">
				<div class="col-sm-3 side_left sm-margin-bottom-20">
					<div class="thumbnail" style="padding: 1px; margin: 15px 0px 2px 0px;">
						<?= Html::a(Avatar::imgLetters($model['thumbnail'], '100%'), [Url::to('/letters/letters/view'), 'cat' => $model['cat']['alias'], 'id' => $model['alias']]) ?>
					</div>
					<div style="padding: 0px; margin: 0px 0px 15px 0px;">
						<i style="padding-left: 2px;">Рейтинг: <strong id="rating_val_<?= $model['id'] ?>"><?= $model['rating'] ?></strong></i>
						<span id="message_<?= $model['id'] ?>"></span>
						<?php if ($model['stage'] != 2) { ?>
							<table width="100%" style="margin: 3px auto;">
								<tr>
									<td width="50%" style="padding-right: 1px;">
										<i id="rating_up_<?= $model['id'] ?>" onclick="rating_up(<?= $model['id'] ?>)" class="rating_btn btn-u btn-brd rounded btn-u-default btn-u-xs" style="width: 100%;">
											<i class="fa fa-thumbs-o-up" style="margin-right: 0px;"></i>&nbsp; <i id="vote_yes_<?= $model['id'] ?>"><?= $model['vote_yes'] ?></i>
										</i>
									</td>
									<td width="50%" style="padding-left: 1px;">
										<i id="rating_down_<?= $model['id'] ?>" onclick="rating_down(<?= $model['id'] ?>)" class="rating_btn btn-u btn-brd rounded btn-u-default btn-u-xs" style="width: 100%;">
											<i class="fa fa-thumbs-o-down" style="margin-right: 0px;"></i>&nbsp; <i id="vote_no_<?= $model['id'] ?>"><?= $model['vote_no'] ?></i>
										</i>
									</td>
								</tr>
							</table>
						<?php } else { ?>
							<br><i class="small-text" style="padding-left: 2px;">Голосование закрыто.</i>
						<?php } ?>
					</div>
				</div>
				<div class="col-md-9">

					<h2 style="font-size: 1.25em; line-height: 22px; margin: 10px 0px 0px 0px;">
						<?= Html::a(Html::encode($model['title']), [Url::to('/letters/letters/view'), 'cat' => $model['cat']['alias'], 'id' => $model['alias']]) ?>
					</h2>

					<p style="margin: 2px 0;"><i class="small-text">Дата:&nbsp;<strong><?= \Yii::$app->formatter->asDate($model['publish'], 'long') ?></strong></i>
						<span style="padding:0 6px;"><i class="small-text">Статус письма:&nbsp;&nbsp;</i><strong><?= Arrays::getLetterStage($model['stage']) ?></strong></span>
						<span style=""><i class="small-text">Категория:&nbsp;&nbsp;</i><strong><?= Html::a($model['cat']['name'], ['/letters/letters/index', 'cat' => $model['cat']['alias']]) ?></strong></span>
					</p>

					<p style="margin: 2px 0;"><?= $model['author'] ? '<i class="small-text">Автор:&nbsp;</i>' . $model['author'] : '' ?></p>

					<div style="text-align: justify;"><?= $model['short_text']; ?></div>
					<div class="container-fluid" style="margin-left:5px; padding: 5px; width: 100%;">
						<?php
						if (!empty($model['tags'])) {
							echo '<span style="margin-right: 15px;">Теги: </span>';
							foreach ($model['tags'] as $tagName) {
								echo Html::a($tagName['name'], ['/tags/tags/index', 'tag' => $tagName['name']], ['class' => 'tags tag_btn']);
							}
						}
						?>
					</div>
				</div>
			</div>

		</div>
	</div>
<?php
$this->registerJsFile('/js/ajax/letters.js', ['depends' => [\yii\web\YiiAsset::className()]]);
?>