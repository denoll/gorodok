<?php

namespace common\models\jobs;

use Yii;

/**
 * This is the model class for table "job_profile".
 *
 * @property string $id_user
 * @property string $education
 * @property string $skills
 * @property string $about
 * @property string $experience
 *
 * @property User $idUser
 */
class JobProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user'], 'required'],
            [['id_user'], 'integer'],
            [['birthday'],'safe'],
            [['sex'], 'string', 'max' => 1],
            [['education'], 'string', 'max' => 25],
            [['skills', 'about'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'sex' => 'Выберите пол',
            'birthday' => 'Укажите дату своего рождения',
            'education' => 'Укажите уровень своего образования',
            'skills' => 'Опишите свои навыки',
            'about' => 'Расскажите о себе',
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
