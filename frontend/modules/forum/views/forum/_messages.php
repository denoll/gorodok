<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 22.12.2015
 * Time: 8:32
 */
use yii\helpers\Html;
use yii\widgets\ListView;
//use common\models\users\User;
?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'viewParams' => [
        'isAdmin' => $this->params['is_admin'],
    ],
    'itemView' => '_message',
    'layout' => '<div class="sorter-block"><i class="small-text">Сортировать:</i> {sorter} {summary} {pager}</div> {items} {pager}',
]); ?>