<?php

/**
 * modules_default_forms_ChatForm
 * 
 * @author valery
 * @version 1
 */
	
class modules_default_forms_ChatForm extends Zend_Form
{

	public function init() 
	{
		$nameElement = new Zend_Form_Element_Text('name');
		$nameElement->setRequired(true);
		$this->addElement($nameElement);
		
		$textElement = new Zend_Form_Element_Textarea('text');
		$textElement->setRequired(true);
		$this->addElement($textElement);
	}

}

