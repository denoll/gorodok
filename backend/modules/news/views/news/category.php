<?php
    use kartik\tree\TreeView;
    use common\models\NewsCat;
    use common\helpers\FaIcons;
	use \kartik\tree\Module;
    use yii\helpers\Url;
    use yii\helpers\Html;

    /**
     * Created by PhpStorm.
     * User: Администратор
     * Date: 02.07.2015
     * Time: 19:31
     */
    $this->title = 'Категории новостей';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="tests-category-index">
    <div class="row">
        <div class="container-fluid">
            <div class="btn-group dropup">
                <?= Html::a('<i class="fa fa-reply"></i> &nbsp;Назад к новостям', Url::home() . 'news/news/index', ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="container-fluid">
            <?php

                $icons = new FaIcons();
                echo TreeView::widget([
                    // single query fetch to render the tree
                    // use the Product model you have in the previous step
                    'query' => NewsCat::find()->addOrderBy('root, lft'),
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
		                'enableCache' => false  // defaults to true
	                ],
	                'nodeAddlViews' => [
		                Module::VIEW_PART_2 => '@backend/modules/news/views/default/element'
	                ]
                ]);
            ?>
        </div>
    </div>
</div>