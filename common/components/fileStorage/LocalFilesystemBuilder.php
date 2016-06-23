<?php
namespace common\components\fileStorage;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use denoll\filekit\filesystem\FilesystemBuilderInterface;
use yii\base\Object;

/**
 * Class LocalFilesystemBuilder
 *
 * Created by DENOLL LLC http://denoll.ru.
 * User:  Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 13.06.2016
 * Time: 6:10
 */
class LocalFilesystemBuilder implements FilesystemBuilderInterface
{
	public $path;

	public function build()
	{
		$adapter = new Local(\Yii::getAlias($this->path));
		return new Filesystem($adapter);
	}
}