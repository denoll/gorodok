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
					<div class="headline"><h2>НАША ТЫНДА</h2></div>
					<p>Городской портал Наша Тында,<br> создан специально для Вас.</p>
				</div>
				<!--/col-md-3-->
				<!-- End About -->

				<!-- Latest -->
				<div class="col-md-3 md-margin-bottom-40">
					<div class="posts">
						<div class="headline"><h2>Меню</h2></div>
						<ul class="list-unstyled link-list">
							<li><?= Html::a('Новости ', ['/news/news/index']) ?><i class="fa fa-angle-right"></i></li>
							<li><?= Html::a('Афиша ', ['/afisha/afisha/index']) ?><i class="fa fa-angle-right"></i></li>
							<li><?= Html::a('Форум ', ['/forum/forum/index']) ?><i class="fa fa-angle-right"></i></li>
							<li><?= Html::a('Товары ', ['/goods/goods/index']) ?><i class="fa fa-angle-right"></i></li>
							<li><?= Html::a('Услуги ', ['/service/service/index']) ?><i class="fa fa-angle-right"></i></li>
							<li><?= Html::a('Недвижимость ', ['/realty/sale/index']) ?><i class="fa fa-angle-right"></i></li>
						</ul>
					</div>
				</div>
				<!--/col-md-3-->
				<!-- End Latest -->

				<!-- Link List -->
				<div class="col-md-3 md-margin-bottom-40">
					<div class="headline"><h2>Полезные ссылки</h2></div>
					<ul class="list-unstyled link-list">
						<li><?= Html::a('О сайте ', ['/page/page/view','id'=>'about']) ?><i class="fa fa-angle-right"></i></li>
						<li><?= Html::a('Как пользоваться ', ['/page/page/index','cat'=>'kak-polzovatsa-sajtom']) ?><i class="fa fa-angle-right"></i></li>
						<li><a href="#">Часто задаваемые вопросы</a><i class="fa fa-angle-right"></i></li>
						<li><a href="#">Обратная связь</a><i class="fa fa-angle-right"></i></li>
						<li><?= Html::a('Реклама на сайте ', ['/page/page/view', 'cat' => 'o-sajte','id'=>'reklama-na-sajte']) ?><i class="fa fa-angle-right"></i></li>
					</ul>
				</div>
				<!--/col-md-3-->
				<!-- End Link List -->

				<!-- Address -->
				<div class="col-md-3 map-img md-margin-bottom-40">
					<div class="headline"><h2>Контакты</h2></div>
					<address class="md-margin-bottom-40">
						Россия, Амурская область <br/>
						г. Тында <br/>
						Email: <a href="mailto:info@nashatynda.ru" class="">info@nashatynda.ru</a> <br/>
						Телефон представителя: <strong>8-914-568-69-02</strong>
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
						2015 - <?= date('Y') ?> &copy; Наша Тында. Все права защищены.
						<a href="#">Политика использования</a> | <a href="#">Правила и соглашения</a>
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

