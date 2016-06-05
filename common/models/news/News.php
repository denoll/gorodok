<?php
namespace common\models\news;

use Yii;
use app\modules\news\Module;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use creocoder\taggable\TaggableBehavior;
use common\models\news\NewsQuery;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\web\UploadedFile;
use common\models\tags\Tags;
use common\widgets\Arrays;

/**
 * This is the model class for table "news".
 *
 * @property string $id
 * @property integer $id_cat
 * @property string $id_tags
 * @property string $on_main
 * @property integer $status
 * @property string $publish
 * @property string $unpublish
 * @property string $title
 * @property string $alias
 * @property string $subtitle
 * @property string $short_text
 * @property string $text
 * @property string $created_at
 * @property string $modifyed_at
 * @property string $autor
 * @property string $m_keyword
 * @property string $m_description
 * @property string $icon
 * @property string $thumbnail
 * @property string $images
 *
 * @property NewsCat $idCat
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * Value of 'published' field where page is not published.
     */
    const PUBLISHED_NO = 0;
    /**
     * Value of 'published' field where page is published.
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'modifyed_at', 'publish'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['modifyed_at'],
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
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','id_cat'], 'required'],
            [['id_cat', 'id_tags'], 'integer'],
            [['status', 'on_main'], 'boolean'],
            [['publish', 'unpublish', 'created_at', 'modifyed_at', 'tagValues', 'img_f', 'crop_info'], 'safe'],
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
            'id_tags' => 'Теги',
            'status' => 'Статус',
            'on_main' => 'На главной',
            'publish' => 'Начало публикации',
            'unpublish' => 'Конец публикации',
            'title' => 'Заголовок',
            'alias' => 'Алиас',
            'subtitle' => 'Подзаголовок',
            'short_text' => 'Краткое описание',
            'text' => 'Полный текст',
            'created_at' => 'Создано',
            'modifyed_at' => 'Изменено',
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
        return new NewsQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(NewsCat::className(), ['id' => 'id_cat']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'id_tag'])
            ->viaTable('tags_news',['id_news'=>'id']);
    }
    public function getTagsNews()
    {
        return $this->hasMany(Tags::className(), ['id' => 'id_tag'])
            ->viaTable('tags_news',['id_news'=>'id']);
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
            $oldImages = FileHelper::findFiles(Yii::getAlias('@frt_dir/img/news/'), [
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
            $pathThumbImage = Yii::getAlias('@frt_dir/img/news/') . 'thumb_'. $imgName;

            $image->resize($newSizeThumb)
                ->crop($cropPointThumb, $cropSizeThumb)
                ->save($pathThumbImage, ['quality' => 100]);
            //Save original image
            $this->image->saveAs(Yii::getAlias('@frt_dir/img/news/'). $imgName);

            //save in database
            $model = News::findOne($this->id);
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

