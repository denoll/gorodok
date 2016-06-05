<?php

namespace common\models\jobs;

use Yii;

/**
 * This is the model class for table "job_cat_vac".
 *
 * @property string $id
 * @property string $id_cat
 * @property string $id_vac
 * @property string $id_user
 *
 * @property JobCategory $idCat
 * @property JobVacancy $idVac
 */
class JobCatVac extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_cat_vac';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cat', 'id_vac', 'id_user'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cat' => 'Id Cat',
            'id_vac' => 'Id Vac',
            'id_user' => 'Id User',
        ];
    }

    public function listCategory($id_vac){
        $query = $this->find()
            ->select(['job_cat_vac.*','job_category.id as cat_id','job_category.parent as parent_id', 'job_category.name as name', '(SELECT `name` FROM job_category WHERE job_category.id = parent_id) AS parent'])
            ->leftJoin('job_category', '`job_category`.`id` = `job_cat_vac`.`id_cat`')
            ->where(['job_category.status' => 1, 'id_vac'=>$id_vac])
            ->asArray()
            ->all();
        return $query;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCat()
    {
        return $this->hasOne(JobCategory::className(), ['id' => 'id_cat']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVac()
    {
        return $this->hasOne(JobVacancy::className(), ['id' => 'id_vac']);
    }
}
