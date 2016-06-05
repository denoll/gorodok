<?php

namespace common\models\tags;

use Yii;

/**
 * This is the model class for table "tags_goods".
 *
 * @property string $id_tag
 * @property string $id_goods
 */
class TagsNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tag', 'id_news'], 'required'],
            [['id_tag', 'id_news'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tag' => 'Id Tag',
            'id_news' => 'Id News',
        ];
    }
}
