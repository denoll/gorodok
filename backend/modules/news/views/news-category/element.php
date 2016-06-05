<?php

	echo '<div class="row">';
		echo '<div class="container-fluid">';
			echo $form->field($node, 'alias')->textarea()->textInput(['maxlength' => true])->label('Алиас');
			echo $form->field($node, 'm_keyword')->textarea()->textarea(['maxlength' => true])->label('Ключевые слова');
			echo $form->field($node, 'm_description')->textarea()->textarea(['maxlength' => true])->label('Мета описание');
		echo'</div>';
	echo'</div>';
