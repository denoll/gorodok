<?php

namespace common\models\forum;

use Yii;

/**
 * This is the model class for table "forum_settings".
 *
 * @property string $name
 * @property string $title
 * @property string $m_description
 * @property string $m_keywords
 * @property integer $count_forums
 * @property integer $count_cat
 * @property integer $count_theme
 * @property integer $count_message
 * @property integer $count_users
 */
class ForumSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['count_forums', 'count_cat', 'count_theme', 'count_message', 'count_users'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['title', 'm_description', 'm_keywords'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'title' => 'Title',
            'm_description' => 'M Description',
            'm_keywords' => 'M Keywords',
            'count_forums' => 'Всего форумов',
            'count_cat' => 'Всего категорий',
            'count_theme' => 'Всего тем',
            'count_message' => 'Всего сообщений',
            'count_users' => 'Count Users',
        ];
    }
}
