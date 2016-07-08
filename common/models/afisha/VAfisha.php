<?php

namespace common\models\afisha;

use Yii;

/**
 * This is the model class for table "v_afisha".
 *
 * @property integer $id
 * @property integer $id_cat
 * @property integer $id_place
 * @property integer $status
 * @property integer $on_main
 * @property string $publish
 * @property string $unpublish
 * @property string $date_in
 * @property string $date_out
 * @property string $title
 * @property string $alias
 * @property string $subtitle
 * @property string $short_text
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 * @property string $autor
 * @property string $m_keyword
 * @property string $m_description
 * @property string $icon
 * @property string $thumbnail
 * @property string $images
 * @property string $cat_slug
 * @property string $name
 */
class VAfisha extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_afisha';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_cat', 'id_place', 'status', 'on_main'], 'integer'],
            [['id_cat'], 'required'],
            [['publish', 'unpublish', 'date_in', 'date_out', 'created_at', 'updated_at'], 'safe'],
            [['short_text', 'text'], 'string'],
            [['title', 'alias', 'subtitle', 'm_keyword', 'm_description', 'icon', 'thumbnail', 'images', 'cat_slug'], 'string', 'max' => 255],
            [['autor'], 'string', 'max' => 45],
            [['name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cat' => 'Категория',
            'id_place' => 'Id Place',
            'status' => 'Статус',
            'on_main' => 'На главной',
            'publish' => 'Начало публикации',
            'unpublish' => 'Конец публикации',
            'date_in' => 'Дата начала',
            'date_out' => 'Дата окончания',
            'title' => 'Заголовок',
            'alias' => 'Алиас',
            'subtitle' => 'Подзаголовок',
            'short_text' => 'Краткое описание',
            'text' => 'Полный текст',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'autor' => 'Автор',
            'm_keyword' => 'Ключевые слова',
            'm_description' => 'Мета описание',
            'icon' => 'Иконка',
            'thumbnail' => 'Миниатюра',
            'images' => 'Изображения',
            'cat_slug' => 'Cat Slug',
            'name' => 'Name',
        ];
    }
}
