<?php
namespace app\modules\letters\assets;

use yii\web\AssetBundle;


	/**
 * Class GoodsAsset
 * @package assets
 */
class LettersAsset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@backend/modules/letters/assets';

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
