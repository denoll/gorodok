<?php

namespace common\models\forum;

use creocoder\taggable\TaggableQueryBehavior;


class ForumQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::className(),
        ];
    }
}