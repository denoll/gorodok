<?php

namespace app\modules\news;
use Yii;
use app\modules\rbac\components\AccessControl;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\news\controllers';
    public $tableName = '{{%news}}';
    public $addImage = false;
    public $uploadImage = true;
    public $pathToImages = '@frt_dir/news/images';
    public $urlToImages  = '@frt_url/news/images';
    public $addFile = false;
    public $uploadFile = false;
    public $pathToFiles;
    public $urlToFiles;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action){
                    return $action->controller->redirect(\Yii::getAlias('@frt_url'));
                },
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();
        if (($this->addImage || $this->uploadImage) && !($this->pathToImages && $this->urlToImages)) {
            throw new InvalidConfigException("For add or upload image via Imperavi Redactor you must be set"
                . " 'pathToImages' and 'urlToImages'.");
        }
        if (($this->addFile || $this->uploadFile) && !($this->pathToFiles && $this->urlToFiles)) {
            throw new InvalidConfigException("For add or upload file via Imperavi Redactor you must be set"
                . " 'pathToFiles' and 'urlToFiles'.");
        }
    }
}
