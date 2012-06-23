<?php

class modules_default_forms_RegisterForm extends Zend_Form {

    public function init() {
        parent::init();

        $this->setMethod('post');

        $element = new Zend_Form_Element_Text('email');
        $element->addFilter(new Zend_Filter_StringTrim());
        $element->setRequired(true);
        $element->setLabel('E-mail');
        $element->addValidator(new Zend_Validate_EmailAddress());
        $this->addElement($element);

        $element = new Zend_Form_Element_Password('password');
        $element->setRequired(true);
        $element->setLabel('Пароль');
        $element->addValidator(new Zend_Validate_StringLength(4, 255));
        $this->addElement($element);

        $element = new Zend_Form_Element_Password('re-password');
        $element->setRequired(true);
        $validatorEqualInputs = new FW_EqualInputs('password');
        $element->addValidator($validatorEqualInputs, false);
        $element->setLabel('Повторите Пароль');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('name');
        $element->addFilter(new Zend_Filter_StringTrim());
        $element->setRequired(true);
        $element->setLabel('Ваше имя');
        $this->addElement($element);
        
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

        $oEl = new Zend_Form_Element_Submit('submit');
		$oEl->setLabel('Регистрация');
		$this->addElement($oEl);

    }

}