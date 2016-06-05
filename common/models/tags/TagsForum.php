<?php

namespace common\models\tags;

use Yii;

/**
 * This is the model class for table "tags_forum".
 *
 * @property string $id_tag
 * @property string $id_forum
 */
class TagsForum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags_forum';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tag', 'id_forum'], 'required'],
            [['id_tag', 'id_forum'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tag' => 'Id Tag',
            'id_forum' => 'Id forum',
        ];
    }
}
