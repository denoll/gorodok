<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 14.10.2015
 * Time: 17:51
 */

//Avatar::widget()

namespace frontend\widgets;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use \yii\bootstrap\Widget;


class AdsSlider extends Widget
{
    public function run($path, $images, $size = null)
    {
        self::registerCss();
        if(!empty($images[0])){
            echo '<div class="demo">';
                echo '<div class="item">';
                    echo '<div class="clearfix" style="">';
                    echo '<ul id="image-gallery" class="gallery list-unstyled cS-hidden">';
                        foreach ($images as $_image) {
                            //$path = Url::to('@frt_url/img/realty_sale/');
                            $image = $_image['img'];
                            echo '<li data-thumb="'.$path.$image.'">';
                            echo '<img src="'.$path.$image.'" style="width: '.$size.' ;" alt="Фото">';
                            echo '</li>';
                        }
                    echo '</ul>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }else{
            if ($size != null) {
                $avtUrl = Url::to('@frt_url/img/no-img.png');
                return Html::img($avtUrl, [
                    'alt' => 'Фото',
                    'style' => 'width:'.$size.';'
                ]);
            } else {

            }
        }
        self::registerJs();
    }


    private function registerCss(){
        $this->registerCssFile('/plugins/light-slider/css/lightslider.min.css', ['depends' => [\frontend\assets\AppAsset::className()]]);
        $this->registerCssFile('/plugins/light-slider/css/style.css', ['depends' => [\frontend\assets\AppAsset::className()]]);
    }

    private  function registerJs(){
$js = <<< JS
    $(document).ready(function () {
            $('#image-gallery').lightSlider({
                gallery:true,
                item:1,
                thumbItem:9,
                slideMargin: 0,
                pause: 4000,
                speed:500,
                auto:true,
                loop:true,
                onSliderLoad: function() {
                    $('#image-gallery').removeClass('cS-hidden');
                }
            });
    });
JS;
        $this->registerJsFile('/plugins/light-slider/js/lightslider.min.js', ['depends' => [\frontend\assets\AppAsset::className()]]);
        $this->registerJs($js, View::POS_END);
    }
}

?>