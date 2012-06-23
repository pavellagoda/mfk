<?php

class modules_default_forms_EditPasswordForm extends Zend_Form {

    public function init() {
        parent::init();

        $this->setMethod('post');

        $element = new Zend_Form_Element_Password('password');
        $element->setRequired(true);
        $element->setLabel('Введите новый пароль');
        $element->addValidator(new Zend_Validate_StringLength(4, 255));
        $this->addElement($element);

        $element = new Zend_Form_Element_Password('re-password');
        $element->setRequired(true);
        $validatorEqualInputs = new FW_EqualInputs('password');
        $element->addValidator($validatorEqualInputs, false);
        $element->setLabel('Повторите Пароль');
        $this->addElement($element);
        
        $oEl = new Zend_Form_Element_Submit('submit');
		$oEl->setLabel('Изменить');
		$this->addElement($oEl);

    }

}