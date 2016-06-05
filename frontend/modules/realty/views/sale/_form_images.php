<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 15.12.2015
 * Time: 17:08
 */
use common\models\realty\RealtySaleImg;

$images = RealtySaleImg::find()->where(['id_ads' => $model->id])->asArray()->all();
$path = Yii::getAlias('@frt_url/img/realty_sale/');
?>

<?php if (count($images) > 0) { ?>
    <div class="cube-portfolio margin-bottom-20">
        <div id="grid-container" class="cbp-l-grid-agency">
            <?php foreach ($images as $item) { ?>
                <div class="cbp-item">
                    <div class="cbp-caption">
                        <div class="cbp-caption-defaultWrap">
                            <img src="<?= $path . $item['img'] ?>" alt="">
                        </div>
                        <div class="cbp-caption-activeWrap">
                            <div class="cbp-l-caption-alignCenter">
                                <div class="cbp-l-caption-body">
                                    <ul class="link-captions">
                                        <li><?= \yii\bootstrap\Html::a('<i class="rounded-x fa fa-trash"></i>', ['delete-image', 'id' => $item['id'], 'id_ads' => $model->id]) ?></li>
                                        <li><a href="<?= $path . $item['img'] ?>" class="cbp-lightbox" data-title="Просмотр фото"><i class="rounded-x fa fa-search"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?= \yii\helpers\Html::a('Удалить все изображения', ['delete-images', 'id' => $model->id]) ?>
<?php } ?>

<?php
$this->registerCssFile('/css/cubeportfolio.min.css', ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->registerCssFile('/css/custom-cubeportfolio.css', ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->registerJsFile('/js/jquery.cubeportfolio.min.js', ['depends' => [\yii\web\YiiAsset::className()]]);
$this->registerJsFile('/js/plugins/cube-portfolio/cube-portfolio-4.js', ['depends' => [\yii\web\YiiAsset::className()]]);

?>