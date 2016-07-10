<?php

namespace common\models\banners;

use Yii;

/**
 * This is the model class for table "banner_adv_block".
 *
 * @property integer $id_adv
 * @property integer $id_banner
 */
class BannerAdvBlock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner_adv_block';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_adv', 'id_banner'], 'required'],
            [['id_adv', 'id_banner'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_adv' => 'Id Adv',
            'id_banner' => 'Id Banner',
        ];
    }
}
