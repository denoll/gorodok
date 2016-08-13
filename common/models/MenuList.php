<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu_list".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $position
 * @property integer $status
 * @property string $data
 *
 * @property Menu[] $menus
 */
class MenuList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['data'], 'string'],
            [['title', 'slug'], 'string', 'max' => 50],
            [['position'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID меню',
            'title' => 'Название',
            'slug' => 'Алиас',
            'position' => 'Позиция',
            'status' => 'Статус',
            'data' => 'Данные меню в формате JSON',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasMany(Menu::className(), ['id_menu' => 'id']);
    }
}
