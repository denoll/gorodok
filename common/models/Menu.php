<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id_menu
 * @property integer $id
 * @property integer $parent
 * @property integer $order
 * @property integer $status
 * @property string $path
 * @property string $alias
 * @property string $title
 * @property string $icon
 * @property string $subtitle
 * @property string $meta_keyword
 * @property string $meta_description
 *
 * @property MenuList $menu
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_menu', 'parent', 'order', 'status'], 'integer'],
            [['path', 'meta_keyword', 'meta_description'], 'string', 'max' => 255],
            [['alias', 'title', 'icon', 'subtitle'], 'string', 'max' => 50],
            [['alias'], 'unique'],
            [['id_menu'], 'exist', 'skipOnError' => true, 'targetClass' => MenuList::className(), 'targetAttribute' => ['id_menu' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_menu' => 'Id Menu',
            'id' => 'ID',
            'parent' => 'Parent',
            'order' => 'Порядок',
            'status' => 'Статус',
            'path' => 'Путь к элементу',
            'alias' => 'Алиас',
            'title' => 'Заголовок',
            'icon' => 'Иконка',
            'subtitle' => 'Подзаоловок',
            'meta_keyword' => 'Ключевые слова',
            'meta_description' => 'Мета описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(MenuList::className(), ['id' => 'id_menu']);
    }
}
