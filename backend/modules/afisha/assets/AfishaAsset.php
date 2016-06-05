<?php
namespace app\modules\afisha\assets;

use yii\web\AssetBundle;


	/**
 * Class GoodsAsset
 * @package assets
 */
class AfishaAsset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@backend/modules/afisha/assets';

    /**
     * @var array
     */
    public $js = [
        'js/ajax.js',
    ];

    public $css = [
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
