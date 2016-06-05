<?php

namespace common\models\tags;

use Yii;

/**
 * This is the model class for table "tags_page".
 *
 * @property string $id_tag
 * @property string $id_page
 */
class TagsPage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tag', 'id_page'], 'required'],
            [['id_tag', 'id_page'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tag' => 'Id Tag',
            'id_news' => 'Id Page',
        ];
    }
}
