<?php

namespace common\models\forum;

use Yii;

/**
 * This is the model class for table "v_forum_messages".
 *
 * @property integer $id
 * @property integer $id_theme
 * @property integer $id_cat
 * @property integer $id_author
 * @property integer $status
 * @property string $created_at
 * @property string $modify_at
 * @property string $message
 * @property string $theme_name
 * @property string $theme_alias
 * @property string $category
 * @property string $cat_alias
 * @property string $username
 * @property string $company_name
 * @property string $avatar
 */
class VForumMessages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_forum_messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_theme', 'id_cat', 'id_author', 'status'], 'integer'],
            [['id_theme', 'id_cat', 'id_author'], 'required'],
            [['created_at', 'modify_at'], 'safe'],
            [['message'], 'string'],
            [['theme_name'], 'string', 'max' => 125],
            [['theme_alias'], 'string', 'max' => 130],
            [['category', 'cat_alias', 'company_name', 'username', 'avatar'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_theme' => 'Id Theme',
            'id_cat' => 'Id Cat',
            'id_author' => 'Id Author',
            'status' => 'Сататус',
            'created_at' => 'Дата сообщения',
            'modify_at' => 'Изменено',
            'message' => 'Сообщение',
            'theme_name' => 'Тема',
            'theme_alias' => 'Theme Alias',
            'category' => 'Категория',
            'cat_alias' => 'Cat Alias',
            'username' => 'Автор',
            'company_name' => 'Компания',
            'avatar' => 'Аватар',
        ];
    }
}
