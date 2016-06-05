<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 24.11.2015
 * Time: 7:24
 */

namespace common\models\goods;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use creocoder\taggable\TaggableQueryBehavior;
use yii\db\ActiveQuery;
/**
 * This is the base query class for the nested set tree
 */
class GoodsQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::className(),
            TaggableQueryBehavior::className(),
        ];
    }
}