<?php

namespace common\models\jobs;

use Yii;

/**
 * This is the model class for table "job_cat_rez".
 *
 * @property string $id
 * @property string $id_cat
 * @property string $id_res
 *
 * @property JobCategory $idCat
 * @property JobResume $idRes
 */
class JobCatRez extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_cat_rez';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cat', 'id_res'], 'integer']
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
            'id_res' => 'Id Res',
        ];
    }

    public function listCategory($id_res){
        $query = $this->find()
            ->select(['job_cat_rez.*','job_category.id as cat_id','job_category.parent as parent_id', 'job_category.name as name', '(SELECT `name` FROM job_category WHERE job_category.id = parent_id) AS parent'])
            ->leftJoin('job_category', '`job_category`.`id` = `job_cat_rez`.`id_cat`')
            ->where(['job_category.status' => 1, 'id_res'=>$id_res])
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
    public function getIdRes()
    {
        return $this->hasOne(JobResume::className(), ['id' => 'id_res']);
    }
}
