<?php
namespace common\models\afisha;

use creocoder\taggable\TaggableQueryBehavior;


class AfishaQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::className(),
        ];
    }
}