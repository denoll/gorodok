<?php

namespace common\models\users;

use Yii;

/**
 * This is the model class for table "user_edu".
 *
 * @property string $id
 * @property string $id_user
 * @property string $name
 * @property string $end_time
 * @property string $faculty
 * @property string $specialty
 *
 * @property User $idUser
 */
class UserEdu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_edu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'end_time'], 'required'],
            [['id', 'id_user'], 'integer'],
            [['name'], 'string', 'max' => 125],
            [['faculty', 'specialty'], 'string', 'max' => 50],
            [['end_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'name' => 'Учебное заведение',
            'end_time' => 'Год завершения обучения',
            'faculty' => 'Факультет',
            'specialty' => 'Специальность',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
