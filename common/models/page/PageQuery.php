<?php
namespace common\models\page;

use creocoder\taggable\TaggableQueryBehavior;


class PageQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::className(),
        ];
    }
}