<?php
namespace common\models\letters;

use Yii;
use app\modules\letters\Module;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use creocoder\taggable\TaggableBehavior;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;
use common\models\tags\Tags;
use common\models\tags\TagsLetters;
use common\widgets\Arrays;
/**
 * This is the model class for table "letters".
 *
 * @property string $id
 * @property integer $id_cat
 * @property string $id_user
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
 * @property string $updated_at
 * @property string $author
 * @property string $m_keyword
 * @property string $m_description
 * @property string $icon
 * @property string $thumbnail
 * @property string $images
 * @property string $rating
 * @property string $vote_yes
 * @property string $vote_no
 * @property string $comments_count
 * @property LettersCat $idCat
 */
class Letters extends \yii\db\ActiveRecord
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
    public $reCaptcha;

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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at','publish'],
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
        return 'letters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','id_cat','id_user'], 'required'],
            ['id_cat', 'validateReadonly'],
            ['tagValues', 'validateTagsCount'],
            [['id_cat','id_user','comments_count','rating','vote_yes','vote_no','stage'], 'integer'],
            [['status', 'on_main'], 'boolean'],
            [['publish', 'unpublish', 'created_at', 'updated_at', 'tagValues', 'img_f', 'crop_info', 'tagValues'], 'safe'],
            [['text','answer'], 'string'],
            [['short_text'], 'string', 'max' => 500],
            [['title', 'alias', 'subtitle', 'm_keyword', 'm_description', 'icon', 'thumbnail', 'images'], 'string', 'max' => 255],
            [['short_text', 'title', 'alias', 'subtitle', 'm_keyword', 'm_description', 'icon', 'thumbnail', 'images'], 'filter', 'filter' => 'strip_tags'],
            [['author'], 'string', 'max' => 45],
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
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'on' => 'create'],
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

    public function validateReadonly()
    {
        $cat = LettersCat::findOne(['id'=>$this->id_cat]);
        if($cat->readonly){
            $readonly = true;
        }else{
            $readonly = false;
        }
        if ($readonly) {
            Yii::$app->session->setFlash('danger', 'Выберите категорию! (Выбирать можно только конечные категории помеченные синими иконками).');
            $this->addError('id_cat', 'Выберите категорию! (Выбирать можно только конечные категории помеченные синими иконками).');
        }
    }
    public function validateTagsCount()
    {
        $tagsCount = TagsLetters::find()->select('Count(*) AS count')->where(['id_letter'=>$this->id])->asArray()->one();
        $post = Yii::$app->request->post('Letters');
        if ($tagsCount['count'] > 3 ||count($post['tagValues']) > 3) {
            Yii::$app->session->setFlash('danger', 'Разрешенное максимальное кол-во тегов 3 штуки! (Сократите теги до трех штук).');
            $this->addError('tagValues', 'Разрешенное максимальное кол-во тегов 3 штуки! (Сократите теги до трех штук).');
            return false;
        }else{
            return true;
        }
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
            'status' => 'Статус',
            'on_main' => 'На главной',
            'stage' => 'Стадия письма',
            'answer' => 'Полученный ответ',
            'comments_count' => 'Кол-во комментариев',
            'rating' => 'Рейтинг письма',
            'vote_yes' => 'Голосов за',
            'vote_no' => 'Голосов против',
            'publish' => 'Начало публикации',
            'unpublish' => 'Конец публикации',
            'title' => 'Заголовок',
            'alias' => 'Алиас',
            'subtitle' => 'Подзаголовок',
            'short_text' => 'Краткое описание',
            'text' => 'Полный текст',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'author' => 'Автор',
            'm_keyword' => 'Ключевые слова',
            'm_description' => 'Мета описание',
            'icon' => 'Иконка',
            'thumbnail' => 'Миниатюра',
            'img_f' => 'Изображения',
            'image' => 'Миниатюра (размеры: 250х250)',
            'reCaptcha' => 'Докажите что Вы не робот.',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        return new LettersQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     * @id LetterID
     */
    public static function commentsCount($id)
    {
        return LettersComments::find()->where(['status'=>1, 'id_letter'=>$id])->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(LettersCat::className(), ['id' => 'id_cat']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommments()
    {
        return $this->hasOne(LettersComments::className(), ['id' => 'id_letter']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'id_tag'])
            ->viaTable('tags_letters',['id_letter'=>'id']);
    }
    public function getTagsLetters()
    {
        return $this->hasMany(Tags::className(), ['id' => 'id_tag'])
            ->viaTable('tags_letters',['id_letter'=>'id']);
    }

    public function afterSave($insert, $changedAttributes){
        // open thumb
        parent::afterSave($insert, $changedAttributes);

        if ($this->image->tempName != '') {

            // open image
            $image = Image::getImagine()->open($this->image->tempName);

            // rendering information about crop of ONE option
            $cropInfo = Json::decode($this->crop_info)[0];
            if((int)$cropInfo['dw'] == 0 || (int)$cropInfo['dh'] == 0){
                $cropInfo['dw'] = Arrays::IMG_SIZE_WIDTH; //new width image
                $cropInfo['dh'] = Arrays::IMG_SIZE_HEIGHT; //new height image
            }else{
                $cropInfo['dw'] = (int)$cropInfo['dw']; //new width image
                $cropInfo['dh'] = (int)$cropInfo['dh']; //new height image
            }
            $cropInfo['x'] = abs($cropInfo['x']); //begin position of frame crop by X
            $cropInfo['y'] = abs($cropInfo['y']); //begin position of frame crop by Y

            //delete old images
            $oldImages = FileHelper::findFiles(Yii::getAlias('@frt_dir/img/letters/'), [
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
            $newSizeThumb = new Box($cropInfo['dw'], $cropInfo['dh']);
            $cropSizeThumb = new Box(Arrays::IMG_SIZE_WIDTH, Arrays::IMG_SIZE_HEIGHT); //frame size of crop
            $cropPointThumb = new Point($cropInfo['x'], $cropInfo['y']);
            $pathThumbImage = Yii::getAlias('@frt_dir/img/letters/') . 'thumb_'. $imgName;

            $image->resize($newSizeThumb)
                ->crop($cropPointThumb, $cropSizeThumb)
                ->save($pathThumbImage, ['quality' => 100]);
            //Save original image
            $this->image->saveAs(Yii::getAlias('@frt_dir/img/letters/'). $imgName);

            //save in database
            $model = Letters::findOne($this->id);
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

