<?php

/**
 * modules_admin_forms_PollVariantEditForm
 * 
 * @author valery
 * @version 1
 */
	
class modules_admin_forms_PollVariantEditForm extends Zend_Form
{

	public function init() 
	{
		$textElement = new Zend_Form_Element_Text('text');
		$textElement->setRequired(true);
		$this->addElement($textElement);
	}

}

