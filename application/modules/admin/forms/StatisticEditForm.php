<?php

/**
 * modules_admin_forms_StatisticEditForm
 *
 * @author valery
 * @version 1
 */

class modules_admin_forms_StatisticEditForm extends Zend_Form
{

	public function init()
	{
		$titleElement = new Zend_Form_Element_Text('title');
		$titleElement->setRequired(true);
		$this->addElement($titleElement);

		$yearElement = new Zend_Form_Element_Textarea('year');
		$yearElement->setRequired(true);
		$this->addElement($yearElement);

		$contentElement = new Zend_Form_Element_Textarea('content');
		$contentElement->setRequired(false);
		$this->addElement($contentElement);
	}

}

