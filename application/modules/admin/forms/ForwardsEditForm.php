<?php

/**
 * modules_admin_forms_GameEditForm
 * 
 * @author valery
 * @version 1
 */
	
class modules_admin_forms_ForwardsEditForm extends Zend_Form
{

	public function init() 
	{
		$tourElement = new Zend_Form_Element_Text('name');
		$tourElement->setRequired(true);
		$this->addElement($tourElement);
		
		$team1Element = new Zend_Form_Element_Text('team');
		$team1Element->setRequired(true);
		$this->addElement($team1Element);
		
		$team2Element = new Zend_Form_Element_Text('goals');
		$team2Element->setRequired(true);
		$this->addElement($team2Element);
		
		$goals1Element = new Zend_Form_Element_Text('pen');
		$goals1Element->setRequired(false);
		$this->addElement($goals1Element);
		
	}

}

