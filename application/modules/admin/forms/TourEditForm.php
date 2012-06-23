<?php

/**
 * modules_admin_forms_TourEditForm
 * 
 * @author valery
 * @version 1
 */
	
class modules_admin_forms_TourEditForm extends Zend_Form
{

	public function init() 
	{
		$titleElement = new Zend_Form_Element_Text('title');
		$titleElement->setRequired(true);
		$this->addElement($titleElement);
		
		$titleElement = new Zend_Form_Element_Text('tournament_id');
		$titleElement->setRequired(true);
		$this->addElement($titleElement);
	}

}

