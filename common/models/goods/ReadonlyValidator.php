<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 29.11.2015
 * Time: 15:02
 */

namespace common\models\goods;
use yii\validators\Validator;

class ReadonlyValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = 'Invalid status input.';
    }

    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        $cat = GoodsCat::findOne(['id' => $value]);
        if ($cat) {
            $model->addError($attribute, $this->message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $statuses = json_encode(Goods::find()->select('id')->asArray()->column());
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
if (!$.inArray(value, $statuses) > -1) {
    messages.push($message);
}
JS;
    }
}