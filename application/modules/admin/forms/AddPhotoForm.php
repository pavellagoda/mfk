<?php

/**
 * modules_admin_forms_TourEditForm
 * 
 * @author valery
 * @version 1
 */
	
class modules_admin_forms_AddPhotoForm extends Zend_Form
{

	public function init() {
        parent::init();
		
        $photoCategories = models_PhotoCategoriesMapper::getAll();
        $options = array();
        foreach($photoCategories as $cat)
        {
        	$options[$cat->id] =  $cat->title;
        }
        
        $this->setMethod('post');

        $element = new Zend_Form_Element_Text('title');
        $element->addFilter(new Zend_Filter_StringTrim());
        $element->setRequired(false);
        $element->setLabel('Название');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Select('category_id');
        $element->addMultiOptions($options);
        $element->setRequired(true);
        $element->setLabel('Альбом');
        $this->addElement($element);

        $element = new Zend_Form_Element_File('files');
		$element->setLabel('Изображение');
		$element->setRequired(false);
		$element->setValueDisabled(true);
		$element->addValidator('Count', false, array('min' => 1, 'max' => 10));
		$element->setMultiFile(10);
		$element->addValidator('File_Extension', false,
			array('jpg'));
		$element->addValidator('File_Size', false,
			array('max' => 1500000));
		$this->addElement($element);

        $element = new Zend_Form_Element_Submit('submit');
		$element->setLabel('Добавить');
		$this->addElement($element);
    }

}

