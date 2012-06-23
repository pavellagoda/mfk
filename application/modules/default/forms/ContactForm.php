<?php
class modules_default_forms_ContactForm extends Zend_Form
{
	public function init()
	{
		$this->setAction('/contact/');

		$oEl = new Zend_Form_Element_Text('name');
		$oEl->setRequired(false);
		$this->addElement($oEl);


		$oEl = new Zend_Form_Element_Text('email');
		$oEl->setRequired(false);
		$this->addElement($oEl);
		

		$oEl = new Zend_Form_Element_Text('msg');
		$oEl->setRequired(false);
		$this->addElement($oEl);

	}
}