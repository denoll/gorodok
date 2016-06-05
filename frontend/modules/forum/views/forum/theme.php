<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 15.08.2015
 * Time: 0:48
 */

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use denoll\editor\CKEditor;
use common\helpers\IsAdmin;
use common\models\users\User;

$this->params['left'] = true;
$this->params['right'] = true;
$this->params['theme_alias'] = $model['alias'];
$this->params['theme_id'] = $model['id'];
$this->params['id_cat'] = $model['id_cat'];
$this->params['is_admin'] = User::isAdmin();
$this->title = $model['name'];
if (!empty($model->m_description)) {
    $this->registerMetaTag(['content' => Html::encode($model['m_description']), 'name' => 'description']);
}
if (!empty($model->m_keyword)) {
    $this->registerMetaTag(['content' => Html::encode($model['m_keyword']), 'name' => 'keywords']);
}
$fio = ($model['idAuthor']['name'] != '' && $model['idAuthor']['surname'] != '') ? $model['idAuthor']['name'].' '.$model['idAuthor']['surname'] : $model['idAuthor']['username'];

$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model['idCat']['name'], 'url' => ['category','id'=>$model['idCat']['alias']]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="letters-view">
    <div class="row">
        <div class="col-sm-12">
            <h1 style="font-size: 1.7em; font-style: italic; font-weight: bolder; margin: 0px;"><?= $model['name'] ?></h1>

            <p>
                <i class="small-text">Автор темы:&nbsp;<?= $fio ?></i>&nbsp;&nbsp;&nbsp;
                <i class="small-text">Дата создания темы:&nbsp;<?= \Yii::$app->formatter->asDate($model['modify_at'], 'long') ?></i>&nbsp;&nbsp;&nbsp;
                <i class="small-text">Тема:&nbsp;<?= \common\widgets\Arrays::getForumThemeStatus($model['status']) ?></i>
            </p>
        </div>
    </div>
    <hr style="margin: 0px 0px 15px 0px; border: 2px solid #ddd;">
    <div class="row">
        <div class="col-sm-12">
            <div><?= $model['description'] ?></div>
        </div>
    </div>
    <hr style="margin: 0px 0px 15px 0px; border: 1px solid #ddd;">
    <div class="row">

        <div class="container-fluid">
            <h4 style="margin: 15px 0px 0px 0px;">Ответы по теме:</h4>
            <?php
            echo $this->render('_messages', [
                'dataProvider' => $dataProvider,
            ]);

            if (!Yii::$app->user->isGuest) {
                if($model['status'] == 1){
                    $new_message = new \common\models\forum\ForumMessage();
                    echo $this->render('_addMessage', [
                        'model' => $new_message
                    ]);
                }else{
                    echo '<h6>Тема закрыта (оставлять новые сообщения в закрытой теме нельзя).</h6>';
                }

            } else { ?>
                <h6>Зарегистрируйтесь или войдите на сайт, чтобы отвечать по теме.</h6>
            <?php } ?>
        </div>
    </div>

</div>
<?php
$this->registerJsFile('/js/ajax/letters.js', ['depends' => [\yii\web\YiiAsset::className()]]);
?>
