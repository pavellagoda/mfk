<?php

class modules_default_forms_EditPhotoForm extends Zend_Form {

    public function init() {
        parent::init();
        
        $photoConfig = Zend_Registry::get('config')->photo;

        $this->setMethod('post');

        $el = new Zend_Form_Element_File('photo');
		$el->setRequired(true);
		$el->addValidator('File_Extension', false, array($photoConfig->extensions));
		$el->addValidator('File_Size', false, array('max' => $photoConfig->max_filesize));
		$el->addValidator('File_ImageSize', false, array(
			'maxwidth' => $photoConfig->max_width,
			'maxheight' => $photoConfig->max_height,
			'minwidth' => $photoConfig->min_width,
			'minheight' => $photoConfig->min_height,
		));
		$this->addElement($el, 'Home Photos');
		
		$oEl = new Zend_Form_Element_Submit('submit');
		$oEl->setLabel('Изменить');
		$this->addElement($oEl);

    }

}