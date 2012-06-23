<?php

/**
 * modules_admin_forms_TourEditForm
 * 
 * @author valery
 * @version 1
 */
	
class modules_admin_forms_AddVideoForm extends Zend_Form
{

	public function init() 
	{
		$oEl = new Zend_Form_Element_Text('title');
		$oEl->setRequired(true);
		$this->addElement($oEl);
		
		$oEl = new Zend_Form_Element_Text('file');
//		$oEl->setRequired(true);
		$this->addElement($oEl);
		
		$oEl = new Zend_Form_Element_Text('thumb');
//		$oEl->setRequired(true);
		$this->addElement($oEl);
		
		$oEl = new Zend_Form_Element_Text('video_categories_id');
//		$oEl->setRequired(true);
		$this->addElement($oEl);
	}

}

