<?php

namespace common\models\users;

use Yii;
use common\widgets\Arrays;
/**
 * This is the model class for table "user_exp".
 *
 * @property string $id
 * @property string $id_user
 * @property string $company
 * @property string $description
 * @property string $region
 * @property string $position
 * @property string $begin
 * @property string $end
 * @property string $experience
 * @property string $site
 *
 * @property User $idUser
 */
class UserExp extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_exp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company', 'description', 'position', 'y_begin', 'm_begin'], 'required'],
            [['id_user'], 'integer'],
            [['m_end', 'm_begin'], 'string', 'max' => 10],
            [['y_end', 'y_begin'], 'string', 'max' => 4],
            [['experience'], 'string'],
            [['company'], 'string', 'max' => 50],
            [['position'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 500],
            [['site'], 'string', 'max' => 30],
            [['now'],'boolean'],
            [['company', 'description', 'position', 'y_begin', 'm_begin', 'm_end', 'y_end', 'site'], 'filter', 'filter' => function($value) {
                return trim(strip_tags($value));
            }],
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
            'company' => 'Организация',
            'now' => 'По настоящее время',
            'description' => 'Описание деятельности компании',
            'position' => 'Должность',
            'experience' => 'Обязанности, функции, достижения',
            'site' => 'Сайт организации',
            'y_begin' => 'Год начала работы',
            'm_begin' => 'Месяц начала работы',
            'y_end' => 'Год окончания работы',
            'm_end' => 'Месяц окончания работы',

        ];
    }

    public function period(){
        if($this->now){
            $per = Arrays::getMonth($this->m_begin,true) .' '. $this->y_begin . '  -  по настоящее время.';
        }else{
            $per = Arrays::getMonth($this->m_begin,true) .' '. $this->y_begin . '  по  ' . Arrays::getMonth($this->m_end) .' '. $this->y_end;
        }
        return 'Период работы:&nbsp; с&nbsp;' . $per;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
