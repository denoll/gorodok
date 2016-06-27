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

    /**
     * @return array
     */
    public function roots()
    {
        return AfishaCat::find()->where(['lvl' => 0, 'active' => 1, 'disabled' => 0, 'visible' => 1])->orderBy('root, lft');
    }
}