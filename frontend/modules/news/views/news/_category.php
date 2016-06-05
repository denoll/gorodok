<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 28.11.2015
 * Time: 4:54
 */
use yii\helpers\Html;
use yii\helpers\Url;


?>
<div class="row">
    <div class="container-fluid">
        <div class="panel panel-default" style="margin-bottom: 5px;">
            <div class="panel-heading" style=" padding: 5px 5px 5px 12px;">
                <h1 class="panel-title" style="display: inline-table;"><?= Html::encode($this->title) ?></h1>
            </div>
            <?php if (!empty($first_child)) { ?>
            <div class="panel-body" style=" padding: 5px 12px 12px 12px;">
                <label class="small-text">Подкатегории:</label>
                <ul class="list-inline" style="margin-bottom: 0;">
                    <?php foreach ($first_child as $item) { ?>
                        <li style="padding: 0;">><?= Html::a($item['name'], ['index', 'cat' => $item['alias']], ['class' => 'btn-u btn-u-sm btn-u-default']) ?></li>
                    <?php } ?>
                </ul>
            </div>
            <?php }else{ $category = \common\models\news\NewsCat::find()->where(['lvl'=>0, 'active'=>1, 'disabled'=>0, 'visible'=>1])->orderBy('root, lft')->asArray()->all(); ?>
                <div class="panel-body" style=" padding: 5px 12px 12px 12px;">
                    <label class="small-text">Категории:</label>
                    <ul class="list-inline" style="margin-bottom: 0;">
                        <?php foreach ($category as $item) {
                            $get = Yii::$app->request->get('cat');
                            if($get == $item['alias']){
                                $active = 'btn-u';
                            }else{
                                $active = 'btn-u-default';
                            }
                         ?>
                            <li style="padding: 0;"><?= Html::a($item['name'], ['index', 'cat' => $item['alias']], ['class' => 'btn-u btn-u-sm '.$active]) ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
</div>