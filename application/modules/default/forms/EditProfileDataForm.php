<?php
class modules_default_forms_EditProfileDataForm extends Zend_Form
{
	public function init() {
        parent::init();

        $this->setMethod('post');
        
        $element = new Zend_Form_Element_Text('name');
        $element->addFilter(new Zend_Filter_StringTrim());
        $element->setRequired(true);
        $element->setLabel('Имя');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('second_name');
        $element->addFilter(new Zend_Filter_StringTrim());
        $element->setRequired(false);
        $element->setLabel('Фамилия');
        $this->addElement($element);

        $element = new Zend_Form_Element_Text('email');
        $element->addFilter(new Zend_Filter_StringTrim());
        $element->setRequired(true);
        $element->setLabel('E-mail');
        $element->setAttrib('readonly', '"readonly"');
        $element->addValidator(new Zend_Validate_EmailAddress());
        $this->addElement($element);


        $oEl = new Zend_Form_Element_Submit('submit');
		$oEl->setLabel('Сохранить');
		$this->addElement($oEl);

    }
}