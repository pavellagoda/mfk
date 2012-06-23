<?php

/**
 * modules_admin_forms_PollEditForm
 * 
 * @author valery
 * @version 1
 */
	
class modules_admin_forms_PollEditForm extends Zend_Form
{

	public function init() 
	{
		$questionElement = new Zend_Form_Element_Text('question');
		$questionElement->setRequired(true);
		$this->addElement($questionElement);
		
		$activeElement = new Zend_Form_Element_Text('active');
		$activeElement->setRequired(false);
		$this->addElement($activeElement);
	}

}

