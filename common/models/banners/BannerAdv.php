<?php

namespace common\models\banners;

use Yii;

/**
 * This is the model class for table "banner_adv".
 *
 * @property integer $id
 * @property integer $status
 * @property string $name
 * @property string $click_price
 * @property string $day_price
 * @property string $description
 *
 * @property BannerItem[] $bannerItems
 */
class BannerAdv extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner_adv';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['click_price', 'day_price'], 'number'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Активная',
            'name' => 'Название рекламной компании',
            'click_price' => 'Стоимость одного клика',
            'day_price' => 'Стоимость одного дня показа',
            'description' => 'Описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBannerItems()
    {
        return $this->hasMany(BannerItem::className(), ['id_adv_company' => 'id'])->inverseOf('idAdvCompany');
    }
}
