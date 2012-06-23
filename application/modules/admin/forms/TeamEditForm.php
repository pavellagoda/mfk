<?php

/**
 * modules_admin_forms_TeamEditForm
 * 
 * @author valery
 * @version 1
 */
	
class modules_admin_forms_TeamEditForm extends Zend_Form
{

	public function init() 
	{
		$titleElement = new Zend_Form_Element_Text('title');
		$titleElement->setRequired(true);
		$this->addElement($titleElement);
	}

}

