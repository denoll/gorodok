<?php

namespace common\models\jobs;

use Yii;
use common\models\users\User;
use \yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "job_vacancy".
 *
 * @property string $id
 * @property string $id_user
 * @property string $top_date
 * @property string $vip_date
 * @property string $title
 * @property string $description
 * @property integer $employment
 * @property string $salary
 * @property string $duties
 * @property string $require
 * @property string $conditions
 * @property string $created_at
 * @property string $updated_at
 * @property string $m_keyword
 * @property string $m_description
 */
class JobVacancy extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    //ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_vacancy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user','title','employment','education'], 'required'],
            [['id_user', 'employment', 'status'], 'integer'],
            [['top_date', 'vip_date', 'created_at', 'updated_at'], 'safe'],
            [['salary'], 'number'],
            [['description', 'duties', 'require', 'conditions'], 'string'],
            [['title'], 'string', 'max' => 125],
            [['education'], 'integer'],
            [['m_keyword', 'm_description', 'address'], 'string' , 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['title', 'description', 'm_keyword', 'm_description', 'address', 'salary'], 'filter', 'filter'=> 'strip_tags'],
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
            'status' => 'Статус',
            'education' => 'Уровень образования',
            'top_date' => 'На верх',
            'vip_date' => 'VIP',
            'title' => 'Вакансия',
            'description' => 'Краткое описание',
            'employment' => 'График работы',
            'salary' => 'Заработная плата',
            'address' => 'Адрес места работы',
            'duties' => 'Обязанности',
            'require' => 'Требования',
            'conditions' => 'Условия',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'm_keyword' => 'Ключевые слова',
            'm_description' => 'Мета описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatVac()
    {
        return $this->hasMany(JobCatVac::className(), ['id_res' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
