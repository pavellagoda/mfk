<?php

/**
 * modules_admin_forms_StatisticGroupEditForm
 *
 * @author valery
 * @version 1
 */

class modules_admin_forms_StatisticGroupEditForm extends Zend_Form
{

	public function init()
	{
		$titleElement = new Zend_Form_Element_Text('title');
		$titleElement->setRequired(true);
		$this->addElement($titleElement);

		$slugElement = new Zend_Form_Element_Textarea('slug');
		$slugElement->setRequired(true);
		$this->addElement($slugElement);
	}

}

