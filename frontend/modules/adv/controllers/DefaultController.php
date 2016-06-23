<?php

namespace app\modules\adv\controllers;

use common\models\banners\BannerItem;
use yii\helpers\Url;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex($id = null)
    {
        if(null != $model = BannerItem::bannerClick($id)){
            return $this->redirect($model->url);
        }else{
            return $this->redirect(\Url::home());
        }
    }
}
