<?php

namespace common\models\firm;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\UploadedFile;
/**
 * This is the model class for table "firm".
 *
 * @property integer $id
 * @property integer $id_cat
 * @property integer $id_user
 * @property integer $status
 * @property integer $show_requisites
 * @property string $name
 * @property string $tel
 * @property string $email
 * @property string $site
 * @property string $logo
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $mk
 * @property string $md
 * @property string $address
 * @property string $lat
 * @property string $lon
 * @property FirmCat $cat
 * @property array $image
 */
class Firm extends \yii\db\ActiveRecord
{
    public $image;
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
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
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
        return 'firm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cat', 'id_user', 'status', 'show_requisites'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['lat','lon'], 'string', 'max' => 100],
            [['tel', 'email', 'site', 'logo', 'address', 'mk', 'md'], 'string', 'max' => 255],
            [['id_cat'], 'exist', 'skipOnError' => true, 'targetClass' => FirmCat::className(), 'targetAttribute' => ['id_cat' => 'id']],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cat' => 'Категория',
            'id_user' => 'Пользователь',
            'image' => 'Логотип',
            'status' => 'Статус',
            'show_requisites' => 'Показывать реквизиты',
            'name' => 'Название компании',
            'tel' => 'Телефон',
            'email' => 'Email',
            'site' => 'Сайт',
            'logo' => 'Логотип',
            'address' => 'Адрес',
            'lat' => 'Широта',
            'lon' => 'Долгота',
            'description' => 'Описание',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'mk' => 'Ключевые слова',
            'md' => 'Мета описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(FirmCat::className(), ['id' => 'id_cat'])->inverseOf('firms');
    }

    public function upload()
    {
        if ($this->validate()) {
            if($this->image->tempName != ''){
                $file_name = $this->image->baseName . '.' . $this->image->extension;
                $this->image->saveAs(Url::to('@frt_dir/img/logo/') . $file_name);
                return $file_name;
            }else{
                return $this->isNewRecord ?  null : $this->logo;
            }
        } else {
            return false;
        }
    }
}
