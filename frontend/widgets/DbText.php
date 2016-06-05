<?php

namespace app\widgets;

use common\models\text\Text;
use yii\base\Widget;
use Yii;

/**
 * Class DbText
 * Return a text block content stored in db
 * @package common\widgets\text
 */
class DbText extends Widget
{
    /**
     * @var string text block key
     */
    public $key;

    /**
     * @return string
     */
    public function run()
    {
        $cacheKey = [
            Text::className(),
            $this->key
        ];
        $content = Yii::$app->cache->get($cacheKey);
        if (!$content) {
            $model =  Text::findOne(['key' => $this->key, 'status' => 1]);
            if ($model) {
                $content = $model->text;
                Yii::$app->cache->set($cacheKey, $content, 60*60*6);
            }
        }
        if(!empty($content)){
            return $content;
        }else return null;
    }
}
