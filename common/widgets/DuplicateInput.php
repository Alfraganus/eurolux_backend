<?php
/**
 * Файл класса DuplicateInput.php
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\widgets;

use sem\widgets\TransliterationInput;

/**
 * Производит зеркалирование вводимого в текущий импут
 */
class DuplicateInput extends TransliterationInput
{
    /**
     * @inheritdoc
     */
    public function registerClientScript()
    {
        $js = "$(function () {
	    var isFirst = true;
	    var wasEmpty = false;

	    $(document).on('change blur focus keyup','input[data-translit_target*=\"#\"]',function(e){

		\$input = $(\$(this).attr('data-translit_target'));
		\$input.bind('keyup',function(e){
		    wasEmpty = false;
		    isFirst = false;
		    return true;
		});

		if(isFirst){
		    isFirst = false;
		    if(!\$input.val())
			    wasEmpty = true;
		}
		
		if(wasEmpty){
			\$input.val($(this).val());
		}
		
		return true;

	    });
	});";
        $view = $this->getView();
        $view->registerJs($js);
    }
}