<?php
    use kartik\tree\TreeView;
    use \kartik\tree\Module;
    use common\models\MainMenu;
    use common\helpers\FaIcons;
    use yii\helpers\Url;
    use yii\helpers\Html;

    /**
     * Created by PhpStorm.
     * User: Администратор
     * Date: 02.07.2015
     * Time: 19:31
     */
    $this->title = 'Основное меню сайта';
    $this->params['breadcrumbs'][] = $this->title;
    $icons = new FaIcons();
?>
<div class="tests-category-index">
    <div class="row">
        <div class="container-fluid">
            <?= Html::a('Меню', 'menu',['class'=>'btn btn-sm btn-default']) ?>
            <?= Html::a('Расширения', '/mainmenu/extensions/index',['class'=>'btn btn-sm btn-default']) ?>
            <?php
                $menu = MainMenu::find()->addOrderBy('root, lft');
                $icons = new FaIcons();
                echo TreeView::widget([
                    // single query fetch to render the tree
                    // use the Product model you have in the previous step
                    'query' => $menu,
                    'headingOptions' => ['label' => 'Меню'],
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
                        Module::VIEW_PART_2 => '@backend/modules/mainmenu/views/default/element'
                    ]
                ]);
            ?>
        </div>
    </div>
</div>