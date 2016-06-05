<?php

namespace app\modules\adv\controllers;

use common\models\banners\BannerItem;
use yii\helpers\Url;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex($id = null)
    {
        if($id){
            $id = base64_decode($id);
            $model = BannerItem::findOne($id);
            $model->updateCounters(['click_count' => 1]);
            $model->save();
            return $this->redirect($model->url);
        }else{
            return $this->redirect(Url::home());
        }
    }
}
