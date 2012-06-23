<?php

/**
 * modules_admin_forms_NewsEditForm
 * 
 * @author valery
 * @version 1
 */
	
class modules_admin_forms_NewsEditForm extends Zend_Form
{

	public function init() 
	{
		$titleElement = new Zend_Form_Element_Text('title');
		$titleElement->setRequired(true);
		$this->addElement($titleElement);
		
		$categoryElement = new Zend_Form_Element_Text('category');
		$categoryElement->setRequired(true);
		$this->addElement($categoryElement);
		
		$tagsElement = new Zend_Form_Element_MultiCheckbox('tags');
		$tagsElement->setIsArray(true);
		$tagsElement->setRegisterInArrayValidator(false);
		$this->addElement($tagsElement);
		
		$shortElement = new Zend_Form_Element_Textarea('short');
		$shortElement->setRequired(true);
		$this->addElement($shortElement);
		
		$fullElement = new Zend_Form_Element_Textarea('full');
		$fullElement->setRequired(false);
		$this->addElement($fullElement);
		
		$fullElement = new Zend_Form_Element_Text('type');
		$fullElement->setRequired(false);
		$this->addElement($fullElement);
	}

}

