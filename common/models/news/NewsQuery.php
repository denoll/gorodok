<?php
namespace common\models\news;

use creocoder\taggable\TaggableQueryBehavior;


class NewsQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::className(),
        ];
    }
}