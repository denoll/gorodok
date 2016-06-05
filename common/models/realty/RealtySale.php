<?php

namespace common\models\realty;

use common\widgets\Arrays;
use Yii;
use common\models\users\User;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;

/**
 * This is the model class for table "realty_sale".
 *
 * @property string $id
 * @property string $id_cat
 * @property string $id_user
 * @property integer $status
 * @property integer $buy
 * @property string $name
 * @property string $cost
 * @property string $area_home
 * @property string $area_land
 * @property integer $floor
 * @property integer $floor_home
 * @property integer $resell
 * @property integer $in_city
 * @property string $distance
 * @property string $main_img
 * @property string $address
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $vip_date
 * @property string $adv_date
 * @property string $m_keyword
 * @property string $m_description
 */
class RealtySale extends \yii\db\ActiveRecord
{
    public $image;
    public $images;
    public $crop_info;
    public $verifyCode;
    public $readonly;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    // ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
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
        return 'realty_sale';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cat', 'name', 'address'], 'required'],
            ['id_cat', 'validateReadonly'],
            [['id_cat', 'id_user', 'status', 'buy', 'floor', 'floor_home', 'resell', 'in_city', 'type', 'elec', 'gas', 'water', 'heating', 'tel_line', 'internet', 'repair','count_img'], 'integer'],
            [['cost', 'area_home', 'area_land', 'distance'], 'number'],
            [['distance'], 'default', 'value'=>0],
            [['description'], 'string', 'max' => 1000],
            [['created_at', 'updated_at', 'vip_date', 'adv_date', 'crop_info'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['main_img', 'address', 'm_keyword', 'm_description'], 'string', 'max' => 255],
            [['id_cat'], 'exist', 'skipOnError' => true, 'targetClass' => RealtyCat::className(), 'targetAttribute' => ['id_cat' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [
                ['image'],
                'image',
                'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
                'mimeTypes' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'],
            ],
            [
                ['images'],
                'image',
                'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
                'mimeTypes' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'],
                'maxFiles' => Arrays::IMG_COUNT,
                'maxSize' => Arrays::IMG_MAX_SIZE, 'maxWidth' => Arrays::IMG_MAX_WIDTH, 'maxHeight' => Arrays::IMG_MAX_HEIGHT,
            ],
            ['verifyCode', 'captcha', 'on' => 'create'],
        ];
    }

    public function validateReadonly()
    {
        $cat = RealtyCat::findOne(['id' => $this->id_cat]);
        if ($cat->readonly) {
            $readonly = true;
        } else {
            $readonly = false;
        }
        if ($readonly) {
            Yii::$app->session->setFlash('danger', 'Выберите категорию! (Выбирать можно только конечные категории помеченные синими иконками).');
            $this->addError('id_cat', 'Выберите категорию! (Выбирать можно только конечные категории помеченные синими иконками).');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер объявления',
            'id_cat' => 'Категория',
            'id_user' => 'Пользователь',
            'status' => 'Статус',
            'buy' => 'Куплю',
            'name' => 'Укажите заголовок обявления',
            'cost' => 'Укажите стоимость',
            'area_home' => 'Площадь',
            'area_land' => 'Площадь участка',
            'floor' => 'Этаж',
            'floor_home' => 'Этажей в доме',
            'resell' => 'Отметьте если это новострока',
            'in_city' => 'Отметьте если объект находится в городе',
            'distance' => 'Расстояние до города (в км.)',
            'repair' => 'Ремонт',
            'type' => 'Тип строения',
            'gas' => 'Газ',
            'water' => 'Вода',
            'heating' => 'Отопление',
            'tel_line' => 'Телефон',
            'internet' => 'Интернет',
            'main_img' => 'Изображение',
            'address' => 'Адрес',
            'description' => 'Описание',
            'created_at' => 'Дата объявления',
            'updated_at' => 'Дата поднятия',
            'vip_date' => 'Выделено',
            'adv_date' => 'Реклама',
            'm_keyword' => 'Ключевые слова',
            'm_description' => 'Мета описание',
        ];
    }

    public function getCat()
    {
        return $this->hasOne(RealtyCat::className(), ['id' => 'id_cat']);
    }

    public function upload()
    {
        if (count($this->images) > 0) {
            $path = Yii::getAlias('@frt_dir/img/realty_sale/');
            $rand = time();
            $count_img = RealtySaleImg::find()->where(['id_ads' => $this->id, 'id_user' => $this->id_user])->count();
            $count = $count_img + count($this->images);
            if ($count <= Arrays::IMG_COUNT) {
                foreach($this->images as $i => $file){
                    $img_name = $this->id . '_' . $this->id_user . '_'. $i . '_' . $rand. '.' . $file->extension;
                    $file->saveAs($path . $img_name);
                    $img_array[$i] = [
                        $this->id,
                        $this->id_user,
                        $img_name,
                    ];
                }
                $db = Yii::$app->db;
                $db->createCommand()->batchInsert('realty_sale_img',['id_ads','id_user','img'],$img_array)->execute();
                return true;
            } else {
                \Yii::$app->session->setFlash('info', '<h2>Превышено кол-во изображений для объявления - ('.$count.').</h2>Изображений для одного объявления должно быть не больше (' . Arrays::IMG_COUNT . ').<br>Для добавления изображения сначало удалите какое-нибудь из старых.');
                return false;
            }
        }return true;
    }

    public static function deleteImages($id, $id_user)
    {
        $f_img = RealtySaleImg::find()->where(['id_ads'=>$id,'id_user'=>$id_user])->asArray()->all();
        $path = Yii::getAlias('@frt_dir/img/realty_sale/');
        if(count($f_img)>0){
            foreach ($f_img as $item) {
                $file = $path . $item['img'];
                if(is_file($file)){
                    if(!unlink($file)){
                        echo 'Файл: '.$item['img'].' - не удален';
                        return false;
                    }
                }
            }
            if(!RealtySaleImg::deleteAll(['id_ads'=>$id,'id_user'=>$id_user])){
                return false;
            }
        }return true;
    }

    public function deleteImage($id, $id_ads, $id_user)
    {
        $img = RealtySaleImg::findOne(['id'=>$id,'id_ads'=>$id_ads,'id_user'=>$id_user]);
        $path = Yii::getAlias('@frt_dir/img/realty_sale/');
        if($img !== null){
            $file = $path . $img['img'];
            if(is_file($file)){
                if(!unlink($file)){
                    echo 'Файл: '.$img['img'].' - не удален';
                    return false;
                }
                if(!$img->delete()) return false;
            }
        }
        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($this->image->tempName != '') {

            // open image
            $image = Image::getImagine()->open($this->image->tempName);

            $variants = [
                [
                    'width' => 250,
                    'height' => 250,
                ],
            ];

            // rendering information about crop of ONE option
            $cropInfo = Json::decode($this->crop_info)[0];
            $cropInfo['dWidth'] = (int)$cropInfo['dWidth']; //new width image
            $cropInfo['dHeight'] = (int)$cropInfo['dHeight']; //new height image
            $cropInfo['x'] = $cropInfo['x']; //begin position of frame crop by X
            $cropInfo['y'] = $cropInfo['y']; //begin position of frame crop by Y

            //delete old images
            $oldImages = FileHelper::findFiles(Yii::getAlias('@frt_dir/img/realty_sale/'), [
                'only' => [
                    $this->id . '.*',
                    'main_' . $this->id . '.*',
                ],
            ]);
            for ($i = 0; $i != count($oldImages); $i++) {
                @unlink($oldImages[$i]);
            }
            //main image name
            $imgName = 'main_' . $this->id . '.' . $this->image->getExtension();

            //saving thumbnail
            $newSizeThumb = new Box($cropInfo['dWidth'], $cropInfo['dHeight']);
            $cropSizeThumb = new Box(250, 250); //frame size of crop
            $cropPointThumb = new Point($cropInfo['x'], $cropInfo['y']);
            $pathThumbImage = Yii::getAlias('@frt_dir/img/realty_sale/') . $imgName;

            $image->resize($newSizeThumb)
                ->crop($cropPointThumb, $cropSizeThumb)
                ->save($pathThumbImage, ['quality' => 100]);

            //save in database
            $model = self::findOne($this->id);
            $model->main_img = $imgName;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Новая картинка успешно установлена.');
            } else {
                Yii::$app->session->setFlash('danger', 'Картинка не изменена.');
            }
        }
    }
}
