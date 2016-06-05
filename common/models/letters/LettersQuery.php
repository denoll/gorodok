<?php
namespace common\models\letters;

use creocoder\taggable\TaggableQueryBehavior;


class LettersQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::className(),
        ];
    }
}