<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 24.11.2015
 * Time: 7:24
 */

namespace common\models\goods;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the base query class for the nested set tree
 */
class GoodsCatAR extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                 'treeAttribute' => 'root',
                 'leftAttribute' => 'lft',
                 'rightAttribute' => 'rgt',
                 'depthAttribute' => 'lvl',
            ],
        ];
    }
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new GoodsQuery(get_called_class());
    }

    // получаем все корни
    public static function getAllRootsNodes()
    {
        return self::find()->roots()->all();
    }

    // получаем все ветви
    public static function getAllLeavesNodes()
    {
        return self::find()->leaves()->all();
    }
    // получаем ветви указанного узла по id
    public static function getLeavesNodesById($id)
    {
        $model = self::findOne(['id'=>$id]);
        return $model->leaves()->all();
    }
    // получаем ветви указанного узла по alias
    public static function getLeavesNodesByAlias($alias)
    {
        $model = self::findOne(['alias'=>$alias]);
        return $model->leaves()->all();
    }


    // получаем всех детей
    public static function getAllChildrenNodes()
    {
        return self::find()->children()->all();
    }
    // получаем детей указанного узла по id
    public static function getChildrenNodesById($id)
    {
        $model = self::findOne(['id'=>$id]);
        return $model->children()->all();
    }
    // получаем детей указанного узла по alias
    public static function getChildrenNodesByAlias($alias)
    {
        $model = self::findOne(['alias'=>$alias]);
        return $model->children()->all();
    }

    // получаем всех родителей указанного узла по id
    public static function getAllParentNodesById($id)
    {
        $model = self::findOne(['id'=>$id]);
        return $model->parents()->all();
    }
    // получаем всех родителей указанного узла по alias
    public static function getAllParentNodesByAlias($alias)
    {
        $model = self::findOne(['alias'=>$alias]);
        return $model->parents()->all();
    }

    // получаем главного родителя указанного узла по id
    public static function getFirstParentNodesById($id)
    {
        $model = self::findOne(['id'=>$id]);
        return $model->parents(1)->all();
    }
    // получаем главного родителя указанного узла по alias
    public static function getFirstParentNodesByAlias($alias)
    {
        $model = self::findOne(['alias'=>$alias]);
        return $model->parents(1)->all();
    }
}