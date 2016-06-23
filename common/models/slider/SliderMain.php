<?php

namespace common\models\slider;

use common\models\users\User;
use Yii;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\web\UploadedFile;

/**
 * This is the model class for table "slider_main".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $name
 * @property string $__image
 * @property string $img
 * @property string $thumbnail
 * @property string $description
 */
class SliderMain extends \yii\db\ActiveRecord
{
	public $image;
	public $crop_info;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'slider_main';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id_user', 'name'], 'required'],
			[['id_user', 'status'], 'integer'],
			[['crop_info', 'image'], 'safe'],
			[['name'], 'string', 'max' => 50],
			[['img', 'thumbnail', 'description'], 'string', 'max' => 255],
			/* [
				 ['image'],
				 'file',
				 //'skipOnEmpty' => false,
				 'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
				 'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
			 ],*/
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'id_user' => 'Пользователь',
			'status' => 'Статус',
			'name' => 'Название',
			'img' => 'Рисунок',
			'thumbnail' => 'Миниатюра',
			'description' => 'Описание',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'id_user']);
	}

	/**
	 * @param $id
	 * @return int
	 */
	public static function changeStatus($id)
	{
		$id = (integer)$id;
		$img = self::findOne($id);
		if ($img->status == 1) {
			$img->status = 0;
		} else {
			$img->status = 1;
		}
		if ($img->save()) {
			return $img->status;
		}
	}

	public function afterSave($insert, $changedAttributes)
	{
		// open thumb
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
			$oldImages = FileHelper::findFiles(Yii::getAlias('@frt_dir/img/slider/'), [
				'only' => [
					$this->id_user . '_' . $this->id . '.*',
					'thumb_' . $this->id_user . '_' . $this->id . '.*',
				],
			]);
			for ($i = 0; $i != count($oldImages); $i++) {
				@unlink($oldImages[$i]);
			}
			//avatar image name
			$imgName = $this->id_user . '_' . $this->id . '.' . $this->image->getExtension();

			//saving thumbnail
			$newSizeThumb = new Box($cropInfo['dWidth'], $cropInfo['dHeight']);
			$cropSizeThumb = new Box(600, 400); //frame size of crop
			$cropPointThumb = new Point($cropInfo['x'], $cropInfo['y']);
			$pathThumbImage = Yii::getAlias('@frt_dir/img/slider/') . 'thumb_' . $imgName;

			$image->resize($newSizeThumb)
				->crop($cropPointThumb, $cropSizeThumb)
				->save($pathThumbImage, ['quality' => 100]);
			//Save original image
			$this->image->saveAs(Yii::getAlias('@frt_dir/img/slider/') . $imgName);

			//save in database
			$model = SliderMain::findOne($this->id);
			$model->thumbnail = 'thumb_' . $imgName;
			$model->img = $imgName;

			if ($model->save()) {
				Yii::$app->session->setFlash('success', 'Новая картинка успешно установлена.');
				return true;
			} else {
				Yii::$app->session->setFlash('danger', 'Картинка не изменена.');
				return false;
			}
		}
	}
}
