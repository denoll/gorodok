<?php

namespace app\modules\tags\controllers;

use common\models\news\News;
use common\models\page\Page;
use common\models\afisha\Afisha;
use common\models\forum\ForumTheme;
use common\models\letters\Letters;
use common\models\tags\Tags;
use tests\models\Tag;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\Sort;

class TagsController extends Controller
{
    public function actionIndex($tag)
    {
        $_tag = Tags::find()
            ->where(['tags.name'=>$tag])
            ->asArray()
            ->one();

        $news = News::find()
            ->select('news.id AS news, id_cat, thumbnail, title, alias, publish, unpublish, news.status')
            ->anyTagValues($tag)
            ->asArray()
            ->where(['news.status' => 1, 'tags.name'=>$tag])
            ->andWhere('publish < NOW() AND unpublish > NOW() OR unpublish IS NULL')
            ->orderBy(['publish'=>SORT_DESC])
            ->all();
        $page = Page::find()
            ->select('page.id AS page, id_cat, thumbnail, title, alias, publish, unpublish, page.status')
            ->anyTagValues($tag)
            ->asArray()
            ->where(['page.status' => 1, 'tags.name'=>$tag])
            ->andWhere('publish < NOW() AND unpublish > NOW() OR unpublish IS NULL')
            ->orderBy(['publish'=>SORT_DESC])
            ->all();
        $afisha = Afisha::find()
            ->select('afisha.id as afisha, id_cat, thumbnail, title, alias, publish, unpublish, afisha.status')
            ->anyTagValues($tag)
            ->asArray()
            ->where(['afisha.status' => 1, 'tags.name'=>$tag])
            ->andWhere('publish < NOW() AND unpublish > NOW() OR unpublish IS NULL')
            ->orderBy(['publish'=>SORT_DESC])
            ->all();
        $letters = Letters::find()
            ->select('letters.id as letters, id_cat, thumbnail, title, alias, publish, unpublish, letters.status')
            ->anyTagValues($tag)
            ->asArray()
            ->where(['letters.status' => 1, 'tags.name'=>$tag])
            ->andWhere('publish < NOW() AND unpublish > NOW() OR unpublish IS NULL')
            ->orderBy(['publish'=>SORT_DESC])
            ->all();
        $forum = ForumTheme::find()
            ->select('forum_theme.id as forum, id_cat, id_author as thumbnail, forum_theme.name as title, alias, created_at as publish, forum_theme.status')
            ->anyTagValues($tag)
            ->asArray()
            ->where(['forum_theme.status' => 1, 'tags.name'=>$tag])
            ->orderBy(['created_at'=>SORT_DESC])
            ->all();
        $arr = array_merge($news, $page, $afisha, $letters, $forum);//Объединяем массивы (сюда можно добавлять еще массивы)
        Sort::orderBy($arr, 'publish DESC');//Сортируем массив по дате, по убяванию (Внешняя библиотека common\helpers\Sort)

        return $this->render('index',[
            'tag'=>$_tag,
            'model'=>$arr,
        ]);
    }
    public function actionAllTags()
    {
        $model = Tags::find()->asArray()->all();
        return $this->render('all-tags',[
            'model'=>$model,
        ]);
    }
}
