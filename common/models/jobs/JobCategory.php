<?php

namespace common\models\jobs;

use Yii;

/**
 * This is the model class for table "job_category".
 *
 * @property string $id
 * @property string $parent
 * @property integer $order
 * @property string $name
 * @property string $description
 * @property string $m_keyword
 * @property string $m_description
 *
 * @property JobCatRez[] $jobCatRezs
 * @property JobCatVac[] $jobCatVacs
 */
class JobCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'order','status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['description', 'm_keyword', 'm_description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent' => 'Parent',
            'order' => 'Порядок',
            'status' => 'Статус',
            'name' => 'Cфера деятельности',
            'description' => 'Описание',
            'm_keyword' => 'Ключевые слова',
            'm_description' => 'Мета описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobCatRezs()
    {
        return $this->hasMany(JobCatRez::className(), ['id_cat' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobCatVacs()
    {
        return $this->hasMany(JobCatVac::className(), ['id_cat' => 'id']);
    }
}
