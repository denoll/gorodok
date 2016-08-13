<?php

use yii\helpers\Html;

?>

<!--=== Footer Version 1 ===-->
<div class="footer-v1">
	<div class="footer">
		<div class="container">
			<div class="row">
				<!-- About -->
				<div class="col-md-3 md-margin-bottom-40">
					<?= \app\widgets\DbText::widget([ 'key' => 'footer_left_block' ]) ?>
				</div>
				<!--/col-md-3-->
				<!-- End About -->

				<!-- Latest -->
				<div class="col-md-3 md-margin-bottom-40">
					<div class="posts">
						<div class="headline"><h2>Меню</h2></div>
						<?= \common\widgets\menu\MenuListWidget::widget([ 'key' => 'footer_left_menu', 'ulOptions' => ['class'=> 'list-unstyled link-list'], 'icon'=>'<i class="fa fa-angle-right"></i>' ]) ?>
					</div>
				</div>
				<!--/col-md-3-->
				<!-- End Latest -->

				<!-- Link List -->
				<div class="col-md-3 md-margin-bottom-40">
					<div class="headline"><h2>Полезные ссылки</h2></div>
					<?= \common\widgets\menu\MenuListWidget::widget([ 'key' => 'footer_right_menu', 'ulOptions' => ['class'=> 'list-unstyled link-list'], 'icon'=>'<i class="fa fa-angle-right"></i>' ]) ?>
				</div>
				<!--/col-md-3-->
				<!-- End Link List -->

				<!-- Address -->
				<div class="col-md-3 map-img md-margin-bottom-40">
					<div class="headline"><h2>Контакты</h2></div>
					<address class="md-margin-bottom-40">
						<?= \app\widgets\DbText::widget([ 'key' => 'footer_kontacts' ]) ?>
					</address>
				</div>
				<!--/col-md-3-->
				<!-- End Address -->
			</div>
		</div>
	</div>
	<!--/footer-->

	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-md-10">
					<p>
						2015 - <?= date('Y') ?> &copy; ООО "НАШ ГОРОД". Все права защищены.
						<?php
						$user = \Yii::$app->user->identity;
						if ($user->username == 'denoll') {
							echo number_format(memory_get_usage() / 1024 / 1024, 3, ',', ' ') . ' | ' . number_format(memory_get_peak_usage() / 1024 / 1024, 3, ',', ' ');
						}
						?>
					</p>
				</div>

				<!-- Social Links -->
				<div class="col-md-2">
					<p>Создано:&nbsp;<a href="http://denoll.ru" target="_blank">denoll</a></p>
				</div>
				<!-- End Social Links -->
			</div>
		</div>
	</div>
	<!--/copyright-->
</div>
<!--=== End Footer Version 1 ===-->

