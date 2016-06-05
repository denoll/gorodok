<?php

namespace common\models\tags;

use Yii;

/**
 * This is the model class for table "tags_afisha".
 *
 * @property string $id_tag
 * @property string $id_afisha
 */
class TagsAfisha extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags_afisha';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tag', 'id_afisha'], 'required'],
            [['id_tag', 'id_afisha'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tag' => 'Id Tag',
            'id_afisha' => 'Id Afisha',
        ];
    }
}
