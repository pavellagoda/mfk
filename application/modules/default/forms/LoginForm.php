<?php
class modules_default_forms_LoginForm extends Zend_Form
{
	public function init()
	{
		$oEmailElement = new Zend_Form_Element_Text('email');
		$oEmailElement -> setRequired(true);
		$oEmailElement->addValidator(new Zend_Validate_EmailAddress());
		$this->addElement($oEmailElement);

		$oPasswordElement = new Zend_Form_Element_Password('password');
		$oPasswordElement->setRequired(true);
		$this->addElement($oPasswordElement);
	}
}