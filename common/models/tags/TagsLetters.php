<?php

namespace common\models\tags;

use Yii;

/**
 * This is the model class for table "tags_letters".
 *
 * @property string $id_tag
 * @property string $id_letters
 */
class TagsLetters extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags_letters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tag', 'id_letters'], 'required'],
            [['id_tag', 'id_letters'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tag' => 'Id Tag',
            'id_letters' => 'Id letters',
        ];
    }
}
