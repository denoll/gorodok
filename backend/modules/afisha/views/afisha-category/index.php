<?php

    use yii\helpers\Html;
    //use yii\grid\GridView;
    use kartik\tree\TreeView;
    use \common\models\afisha\AfishaCat;
    use common\helpers\FaIcons;
	use \kartik\tree\Module;
    use yii\helpers\Url;

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = 'Категории афиши';
    $this->params['breadcrumbs'][] = $this->title;
    $icons = new FaIcons();

?>
<div class="tests-category-index">
    <div class="row">
        <div class="container-fluid">
            <div class="btn-group dropup">
                <?= Html::a('<i class="fa fa-reply"></i> &nbsp;Назад к статьям',[ Url::to('/afisha/afisha/index')], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="container-fluid">

            <?= TreeView::widget([
                // single query fetch to render the tree
                // use the Product model you have in the previous step
                'query' => AfishaCat::find()->addOrderBy('root, lft'),
                'headingOptions' => ['label' => 'Категории'],
                'rootOptions' => ['label' => '<span class="text-primary">Кореневая директория</span>'],
                'fontAwesome' => true,     // optional
                'isAdmin' => true,         // optional (toggle to enable admin mode)
                'displayValue' => 1,        // initial display value
                'softDelete' => false,       // defaults to true
                'iconEditSettings' => [
                    'show' => 'list',
                    'listData' => $icons->faIcons(),
                ],
                'cacheSettings' => [
                    'enableCache' => false   // defaults to true
                ],
	            'nodeAddlViews' => [
		            Module::VIEW_PART_2 => '@backend/modules/afisha/views/afisha-category/element'
	            ]
            ]); ?>
        </div>
    </div>
</div>
