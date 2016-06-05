<?php

namespace common\models\jobs;

use Yii;

/**
 * This is the model class for table "v_resume".
 *
 * @property string $id_user
 * @property string $username
 * @property string $email
 * @property string $tel
 * @property string $fio
 * @property string $avatar
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $salary
 * @property string $created_at
 * @property string $vip_date
 * @property string $education
 * @property string $skills
 * @property string $about
 */
class VResume extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_resume';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id', 'status', 'education', 'employment'], 'integer'],
            [['username', 'email'], 'required'],
            [['salary'], 'number'],
            [['updated_at', 'created_at', 'vip_date', 'birthday'], 'safe'],
            [['skills', 'about', 'search_field'], 'string'],
            [['username', 'email', 'description'], 'string', 'max' => 255],
            [['sex'], 'string', 'max' => 1],
            [['tel'], 'string', 'max' => 15],
            [['fio'], 'string', 'max' => 152],
            [['avatar'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 125],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'username' => 'Логин',
            'email' => 'Email',
            'tel' => 'Телефон',
            'fio' => 'Fio',
            'sex' => 'Пол',
            'avatar' => 'Аватар',
            'id' => 'ID',
            'employment' => 'График работы',
            'title' => 'Должность (позиция)',
            'description' => 'Краткое описание',
            'salary' => 'Заработная плата',
            'created_at' => 'Дата создания',
            'vip_date' => 'Vip Date',
            'education' => 'Образование',
            'skills' => 'Skills',
            'about' => 'About',
        ];
    }
}
