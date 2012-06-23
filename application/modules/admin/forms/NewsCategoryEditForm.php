<?php

/**
 * modules_admin_forms_NewsCategoryEditForm
 * 
 * @author valery
 * @version 1
 */
	
class modules_admin_forms_NewsCategoryEditForm extends Zend_Form
{

	public function init() 
	{
		$nameElement = new Zend_Form_Element_Text('name');
		$nameElement->setRequired(true);
		$this->addElement($nameElement);
	}

}

