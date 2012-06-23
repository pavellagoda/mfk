<?php

/**
 * modules_admin_forms_StatisticEditForm
 *
 * @author valery
 * @version 1
 */

class modules_admin_forms_ArchivEditForm extends Zend_Form
{

	public function init()
	{
		$contentElement = new Zend_Form_Element_Textarea('content');
		$contentElement->setRequired(false);
		$this->addElement($contentElement);
	}

}

