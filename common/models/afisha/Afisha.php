<?php
namespace common\models\afisha;

use Yii;
use app\modules\afisha\Module;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use creocoder\taggable\TaggableBehavior;
use common\models\afisha\AfishaQuery;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\web\UploadedFile;
use common\models\tags\Tags;
use common\widgets\Arrays;

/**
 * This is the model class for table "afisha".
 *
 * @property string $id
 * @property integer $id_cat
 * @property string $id_place
 * @property string $on_main
 * @property integer $status
 * @property string $publish
 * @property string $unpublish
 * @property string $date_in
 * @property string $date_out
 * @property string $title
 * @property string $alias
 * @property string $subtitle
 * @property string $short_text
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 * @property string $autor
 * @property string $m_keyword
 * @property string $m_description
 * @property string $icon
 * @property string $thumbnail
 * @property string $images
 *
 * @property AfishaCat $idCat
 */
class Afisha extends \yii\db\ActiveRecord
{
    /**
     * Value of 'published' field where afisha is not published.
     */
    const PUBLISHED_NO = 0;
    /**
     * Value of 'published' field where afisha is published.
     */
    const PUBLISHED_YES = 1;

    var $img_f;
    public $image;
    public $crop_info;


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'alias',
                'immutable' => true,
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at', 'publish'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'taggable' => [
                'class' => TaggableBehavior::className(),
                 'tagValuesAsArray' => true,
                 'tagRelation' => 'tags',
                 'tagValueAttribute' => 'name',
                 'tagFrequencyAttribute' => 'frequency',
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'afisha';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','id_cat','id_place'], 'required'],
            [['id_cat', 'id_place'], 'integer'],
            [['status', 'on_main'], 'boolean'],
            [['publish', 'unpublish', 'created_at', 'updated_at', 'tagValues', 'img_f', 'crop_info','date_in','date_out'], 'safe'],
            [['short_text', 'text'], 'string'],
            [['title', 'alias', 'subtitle', 'm_keyword', 'm_description', 'icon', 'thumbnail', 'images'], 'string', 'max' => 255],
            [['autor'], 'string', 'max' => 45],
            [['title'], 'unique'],
            [
                ['img_f'],
                'file',
                //'skipOnEmpty' => false,
                'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
                'mimeTypes' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'],
                'maxFiles' => 20
            ],
            [
                ['image'],
                'file',
                //'skipOnEmpty' => false,
                'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
                'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
            ],

        ];
    }
    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
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
            'id_place' => 'Место',
            'status' => 'Статус',
            'on_main' => 'На главной',
            'publish' => 'Начало публикации',
            'unpublish' => 'Конец публикации',
            'date_in' => 'Дата начала',
            'date_out' => 'Датат окончания',
            'title' => 'Заголовок',
            'alias' => 'Алиас',
            'subtitle' => 'Подзаголовок',
            'short_text' => 'Краткое описание',
            'text' => 'Полный текст',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'autor' => 'Автор',
            'm_keyword' => 'Ключевые слова',
            'm_description' => 'Мета описание',
            'icon' => 'Иконка',
            'thumbnail' => 'Миниатюра',
            'img_f' => 'Изображения',
            'image' => 'Миниатюра (размеры: 250х250)',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        return new AfishaQuery(get_called_class());
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlace()
    {
        return $this->hasOne(AfishaPlace::className(), ['id' => 'id_place']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(AfishaCat::className(), ['id' => 'id_cat']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'id_tag'])
            ->viaTable('tags_afisha',['id_afisha'=>'id']);
    }
    public function getTagsAfisha()
    {
        return $this->hasMany(Tags::className(), ['id' => 'id_tag'])
            ->viaTable('tags_afisha',['id_afisha'=>'id']);
    }

    public function afterSave($insert, $changedAttributes){
        // open thumb
        parent::afterSave($insert, $changedAttributes);

        if ($this->image->tempName != '') {

            // open image
            $image = Image::getImagine()->open($this->image->tempName);

            // rendering information about crop of ONE option
            $cropInfo = Json::decode($this->crop_info)[0];
            if((int)$cropInfo['dWidth'] == 0 || (int)$cropInfo['dHeight'] == 0){
                $cropInfo['dWidth'] = Arrays::IMG_SIZE_WIDTH; //new width image
                $cropInfo['dHeight'] = Arrays::IMG_SIZE_HEIGHT; //new height image
            }else{
                $cropInfo['dWidth'] = (int)$cropInfo['dWidth']; //new width image
                $cropInfo['dHeight'] = (int)$cropInfo['dHeight']; //new height image
            }
            $cropInfo['x'] = $cropInfo['x']; //begin position of frame crop by X
            $cropInfo['y'] = $cropInfo['y']; //begin position of frame crop by Y

            //delete old images
            $oldImages = FileHelper::findFiles(Yii::getAlias('@frt_dir/img/afisha/'), [
                'only' => [
                    $this->id . '.*',
                    'thumb_' . $this->id . '.*',
                ],
            ]);
            for ($i = 0; $i != count($oldImages); $i++) {
                @unlink($oldImages[$i]);
            }
            //avatar image name
            $imgName = $this->id . '.' . $this->image->getExtension();

            //saving thumbnail
            $newSizeThumb = new Box($cropInfo['dWidth'], $cropInfo['dHeight']);
            $cropSizeThumb = new Box(Arrays::IMG_SIZE_WIDTH, Arrays::IMG_SIZE_HEIGHT); //frame size of crop
            $cropPointThumb = new Point($cropInfo['x'], $cropInfo['y']);
            $pathThumbImage = Yii::getAlias('@frt_dir/img/afisha/') . 'thumb_'. $imgName;

            $image->resize($newSizeThumb)
                ->crop($cropPointThumb, $cropSizeThumb)
                ->save($pathThumbImage, ['quality' => 100]);
            //Save original image
            $this->image->saveAs(Yii::getAlias('@frt_dir/img/afisha/'). $imgName);

            //save in database
            $model = Afisha::findOne($this->id);
            $model->thumbnail = 'thumb_'.$imgName;
            $model->images = $imgName;

            if($model->save()){
                Yii::$app->session->setFlash('success', 'Новая картинка успешно установлена.');
                return true;
            }else{
                Yii::$app->session->setFlash('danger', 'Картинка не изменена.');
                return false;
            }
        }
    }

    public function mkdir_r($dirName, $rights=0755){
        $dirs = explode('/', $dirName);
        $dir='';
        foreach ($dirs as $part) {
            $dir.=$part.'/';
            if (!is_dir($dir) && strlen($dir)>0)
                mkdir($dir, $rights);
        }
    }


}

