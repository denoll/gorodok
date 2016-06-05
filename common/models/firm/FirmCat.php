<?php

namespace common\models\firm;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * This is the model class for table "firm_cat".
 *
 * @property integer $id
 * @property integer $id_parent
 * @property integer $status
 * @property integer $order
 * @property string $name
 * @property string $slug
 * @property string $mk
 * @property string $md
 *
 * @property Firm[] $firms
 * @property FirmCat $idParent
 * @property FirmCat[] $firmCats
 */
class FirmCat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable' => true,
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'firm_cat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_parent', 'status', 'order'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['slug', 'mk', 'md'], 'string', 'max' => 255],
            [['id_parent'], 'exist', 'skipOnError' => true, 'targetClass' => FirmCat::className(), 'targetAttribute' => ['id_parent' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_parent' => 'Родительская категория',
            'status' => 'Status',
            'order' => 'Порядок',
            'name' => 'Категория',
            'slug' => 'Алиас',
            'mk' => 'Ключевые слова',
            'md' => 'Мета описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFirms()
    {
        return $this->hasMany(Firm::className(), ['id_cat' => 'id'])->inverseOf('idCat');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdParent()
    {
        return $this->hasOne(FirmCat::className(), ['id' => 'id_parent'])->inverseOf('firmCats');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFirmCats()
    {
        return $this->hasMany(FirmCat::className(), ['id_parent' => 'id'])->inverseOf('idParent');
    }
}
