<?php
/**
 * Отдельные сообщения форума
 */
use \common\models\users\User;

$admin = $model['auth']['item_name'] === 'admin' ? true : false;
$authorTheme = $model['idTheme']['id_author'] === $model['idAuthor']['id'];

$isAuthorTheme = $model['idTheme']['id_author'] === Yii::$app->user->getId() ? true : false;
$isAuthorMessage = $model['idAuthor']['id'] === Yii::$app->user->getId() ? true : false;

if ($model['status'] == 0) {
    if ($isAuthorMessage || $isAuthorTheme || $isAdmin) {
        $display = true;
        $message = 'Сообщение видно только Вам и автору темы';
    } else {
        $display = false;
    }
} else {
    $display = true;
}

$fio = $model['idAuthor']['username'];

?>
<?php if ($display) { ?>
    <div class="panel panel-default">
        <div class="panel-heading" style="background-color: #eee; padding-left: 6px;">
            <table>
                <tr>
                    <td rowspan="2">
                        <?= \frontend\widgets\Avatar::userAvatar($model['idAuthor']['avatar'], '60px; border: 1px solid #c6c6c6; border-radius: 50% !important; padding: 1px; ') ?>
                    </td>
                    <td style="padding: 2px 0px 2px 10px; font-size: 0.85em;">
                        <?= $model['idAuthor']['username'] ? '<i><strong>' . $fio . '</strong></i>' : '' ?>
                    </td>
                    <td>
                        <?php if ($admin) { ?>
                            <i style="margin: 2px 0px 2px 10px; font-size: 0.75em; color: #9C0000;">Администратор</i>
                        <?php }
                        if ($authorTheme) { ?>
                            <i style="margin: 2px 0px 2px 10px; font-size: 0.75em; color: #52A855;">Автор темы</i>
                        <?php } else { ?>
                            <i style="margin: 2px 0px 2px 10px; font-size: 0.75em; color: #5262A8;">Пользователь</i>
                        <?php } ?>
                    </td>
                    <td style="padding: 2px 0px 2px 10px; font-size: 0.75em;">
                        <i class="small-text">&nbsp;<?= \Yii::$app->formatter->asDate($model['created_at'], 'long') ?></i>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 2px 0px 2px 10px; font-size: 0.75em;">
                        <i>Создал тем: <?= $model['idAuthor']['count_ft'] != '' ? $model['idAuthor']['count_ft'] : 0 ?></i>&nbsp;&nbsp;
                        <i>Создал сообщений: <?= $model['idAuthor']['count_fm'] ?></i>
                    </td>
                    <td style="padding: 2px 0px 2px 10px; font-size: 0.75em;">
                        <?php if ($isAdmin || $isAuthorTheme || $isAuthorMessage) { ?>
                            <?= \yii\helpers\Html::a('<i class="fa fa-pencil"></i>&nbsp;Ред.', ['update-message', 'id' => $model['id']]) ?>&nbsp;&nbsp;
                            <?= \yii\helpers\Html::a('<i class="fa fa-trash"></i>&nbsp;Удалить', ['del-message', 'id' => $model['id']]) ?>
                        <?php } ?>
                    </td>
                </tr>
            </table>


        </div>
        <div class="panel-body" style="padding: 10px;">
            <?= $message != '' ? '<i class="small-text" style="color: #000077; margin-top: -10px;">' . $message . '</i><br>' : '' ?>
            <?= nl2br($model['message']) ?>
        </div>
    </div>
<?php } ?>