<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User:  Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 11.06.2016
 * Time: 9:59
 */

namespace common\behaviors;

use yii\base\Behavior;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class FileStorageBehavior extends Behavior
{
	/**
	 * @param string $directory
	 * @param Model $model
	 * @param UploadedFile $file
	 * @param string $file_name
	 *
	 * @param string $image_height
	 * @param string $image_width
	 * @param string $image_quality
	 */
	public $directory;
	public $model;
	public $file;
	public $file_name;
	public $image_height;
	public $image_width;
	public $image_quality;

	public function attach($owner)
	{
		parent::attach($owner);
		$owner->on(ActiveRecord::EVENT_BEFORE_INSERT, [$this, 'onBeforeSave']);
		$owner->on(ActiveRecord::EVENT_BEFORE_UPDATE, [$this, 'onBeforeSave']);
		$owner->on(ActiveRecord::EVENT_BEFORE_DELETE, [$this, 'onBeforeDelete']);
	}

	public function init()
	{
		\Yii::$app->fileStorage->directory = $this->directory;
		\Yii::$app->fileStorage->model = $this->model;
		\Yii::$app->fileStorage->file = $this->file;
		\Yii::$app->fileStorage->file_name = $this->file_name;
		$this->image_height ? \Yii::$app->fileStorage->image_height = $this->image_height:null;
		$this->image_width ? \Yii::$app->fileStorage->image_width = $this->image_width:null;
		$this->image_quality ? \Yii::$app->fileStorage->image_quality = $this->image_quality:null;

		parent::init();
	}

	public function onBeforeSave($event)
	{
		$model = $this->owner;
		$file_name = \Yii::$app->fileStorage->uploadFile($model, $this->directory);
		if($file_name){
			$model->{$this->file_name} = $file_name;
		}
	}

	public function onBeforeDelete($event){
		$model = $this->owner;
		\Yii::$app->fileStorage->deleteFile($model->{$this->file_name});
	}
}