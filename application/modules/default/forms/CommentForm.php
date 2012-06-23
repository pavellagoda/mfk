<?php

/**
 * modules_default_forms_CommentForm
 * 
 * @author valery
 * @version 1
 */
	
class modules_default_forms_CommentForm extends Zend_Form
{

	public $captcha;
	
	public function init() 
	{
		$textElement = new Zend_Form_Element_Textarea('text');
		$textElement->setRequired(true);
		$this->addElement($textElement);
//		Zend_Captcha_ReCaptcha::
        $captchaElement = new Zend_Form_Element_Captcha('captcha', array(

//		 'decorators' => array(array('ViewHelper' )),
	                'captcha' => array(
	                    'captcha' => 'Image',
	                    'wordLen' => 4,
	                    'timeout' => 300,
	                    'font'    => 'fonts/arial.ttf',
	                    'imgDir'  => 'img/captcha',
	                    'imgUrl'  => '/img/captcha',
	                )
	            ));

		$this->captcha = $captchaElement;
		
        $this->addElement($captchaElement);
	}

}

