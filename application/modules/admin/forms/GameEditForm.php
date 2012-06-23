<?php

/**
 * modules_admin_forms_GameEditForm
 * 
 * @author valery
 * @version 1
 */
	
class modules_admin_forms_GameEditForm extends Zend_Form
{

	public function init() 
	{
		$tourElement = new Zend_Form_Element_Text('tour_id');
		$tourElement->setRequired(true);
		$this->addElement($tourElement);
		
		$team1Element = new Zend_Form_Element_Text('team_id_1');
		$team1Element->setRequired(true);
		$this->addElement($team1Element);
		
		$team2Element = new Zend_Form_Element_Text('team_id_2');
		$team2Element->setRequired(true);
		$this->addElement($team2Element);
		
		$goals1Element = new Zend_Form_Element_Text('goals_1');
		$goals1Element->setRequired(false);
		$this->addElement($goals1Element);
		
		$goals2Element = new Zend_Form_Element_Text('goals_2');
		$goals2Element->setRequired(false);
		$this->addElement($goals2Element);
		
		$completedElement = new Zend_Form_Element_Text('completed');
		$completedElement->setRequired(false);
		$this->addElement($completedElement);
		
		$completedElement = new Zend_Form_Element_Text('news_id');
		$completedElement->setRequired(false);
		$this->addElement($completedElement);
		
		$completedElement = new Zend_Form_Element_Text('sportcomplex_id');
		$completedElement->setRequired(false);
		$this->addElement($completedElement);
		
		$completedElement = new Zend_Form_Element_Text('date');
		$completedElement->setRequired(false);
		$this->addElement($completedElement);
		
		$completedElement = new Zend_Form_Element_Text('time');
		$completedElement->setRequired(false);
		$this->addElement($completedElement);
		
	}

}

