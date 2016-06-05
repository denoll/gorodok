<?php

    use yii\helpers\Html;
    use kartik\tree\TreeView;
    use common\helpers\FaIcons;
	use \kartik\tree\Module;
    use yii\helpers\Url;

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = 'Категории товаров';
    $this->params['breadcrumbs'][] = $this->title;
    $icons = new FaIcons();

?>
<div class="tests-category-index">
    <div class="row">
        <div class="container-fluid">
            <div class="btn-group dropup">
                <?= Html::a('<i class="fa fa-reply"></i> &nbsp;Назад к объявлениям',[ Url::to('/realty/sale/index')], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="container-fluid">

            <?= TreeView::widget([
                // single query fetch to render the tree
                // use the Product model you have in the previous step
                'query' => \common\models\realty\RealtyCat::find()->addOrderBy('root, lft'),
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
		            Module::VIEW_PART_2 => '@backend/modules/realty/views/category/element'
	            ]
            ]); ?>
        </div>
    </div>
</div>
