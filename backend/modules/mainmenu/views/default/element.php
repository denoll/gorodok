<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\helpers\Arrays;

$extensions = \common\models\MainMenu::getExtensions();
$elements = [];
echo '<div class="row">';
echo '<div class="col-md-6">';
echo $form->field($node, '_extensions')->dropDownList(ArrayHelper::map($extensions, 'id', 'name'), ['id' => '_ext', 'onchange' => 'selectExt()'])->label('Выберите расширение');
echo '</div>';
echo '<div class="col-md-6">';
echo $form->field($node, '_items')->dropDownList(ArrayHelper::map($elements, 'id', 'name'), ['id' => '_items', 'onchange' => 'selectItem()', 'onClick' => 'selectItem()'])->label('Выберите элемент');
echo '</div>';

echo '<div class="col-md-5">';
echo $form->field($node, 'url')->textarea()->textInput(['maxlength' => true])->label('Url');
echo '</div>';
echo '<div class="col-md-2">';
echo $form->field($node, 'var')->textInput(['maxlength' => true]);
echo '</div>';
echo '<div class="col-md-5">';
echo $form->field($node, 'cat')->textarea()->textInput(['maxlength' => true])->label('Алиас элемента');
echo '</div>';
echo '<div class="col-md-6">';
echo $form->field($node, 'm_k')->textarea()->textarea(['maxlength' => true])->label('Meta tag keyword');
echo '</div>';
echo '<div class="col-md-6">';
echo $form->field($node, 'm_d')->textarea()->textarea(['maxlength' => true])->label('Meta tag description');
echo '</div>';
echo '</div>';

echo '<pre id="pre">';

echo '</pre>';

$js = <<<JS
	function selectExt(){
		var ext_id =  $('#_ext').val();
		console.log('Change ' + ext_id);
		$.ajax({
        type: "post",
        url: "select-ext",
        data: "id=" + ext_id,
        cache: true,
        dataType: "json",
        success: function (data) {
        			$('#mainmenu-url').val(data.ext.url);
        			$('#mainmenu-var').val(data.ext.var);
        			if(data.items != null){
        				$('#_items').empty();
						var options = '';
						$(data.items).each(function(){
							options += '<option value="' + $(this).attr('id') + '">' + $(this).attr('name') + '</option>';
						});
						$('#_items').html(options);
        			}else{
        				$('#_items').empty();
        			}
        			if(data.ext.type == 'main'){
        				$('#mainmenu-cat').val(null);
        			}
        	}
    	});
	}

	function selectItem(){
		var item_id =  $('#_items').val();
		var ext_id = $('#_ext').val();
		$.ajax({
        type: "post",
        url: "select-item",
        data: "item_id=" + item_id + "&ext_id=" + ext_id,
        cache: true,
        dataType: "json",
        success: function (data) {
        		if(data.items != null){
        		if(data.ext.ext_name == 'article' || data.ext.ext_name == 'news' || data.ext.ext_name == 'training'){
        			if(data.ext.ext_name == 'training'){
        				$('#mainmenu-cat').val(data.items.id);
        			}else{
        			$('#mainmenu-cat').val(data.items.slug);
        			}
        		}else{
        			$('#mainmenu-cat').val(data.items.slug);
        		}
        		}else{
        			$('#mainmenu-cat').val(null);
        		}
        	}
    	});
	}
JS;
$this->registerJs($js);


