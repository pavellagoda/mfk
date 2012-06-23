<?php

/**
 * Admin NewscategoryController
 * 
 * @author valery
 * @version 1
 */

class Admin_PhotoController extends modules_admin_controllers_ControllerBase
{

    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	$request = $this->getRequest();
    	
    	$page = $request->getParam('page', 1);
    	
    	$photos = models_PhotoMapper::getAllWithCategoryPage($page);
    	
    	$this->view->photos = $photos;
    	
    }
    
	public function addAction()
    {
    	$request = $this->getRequest();
    	
    	$form = new modules_admin_forms_AddPhotoForm();
    	
    	if ($request->isPost())
    	{
    		if ($form->isValid($request->getPost()))
    		{
    			$files = $_FILES['files']['name'];
    			foreach($files as $i=>$file)
    			{
    				if($file!='')
    				{
	    				$photo = new models_Photo();
	    				$photo->idPhotoCategories = $form->getValue('category_id');
	    				$photo->title = $form->getValue('title');
						$idPhoto = models_PhotoMapper::save($photo);
						
						$path = $_SERVER['DOCUMENT_ROOT'] . '/photofiles/'.$photo->idPhotoCategories.'/'.$idPhoto.'.jpg';
						
						move_uploaded_file($_FILES['files']['tmp_name'][$i],$path);
    				}
    				
    			}
    			
    			$this->_redirect('/admin/photo');
    		}
    	}
    	
    	$this->view->form = $form;
    	
    }
    
	public function deleteAction()
    {
    	$request = $this->getRequest();
    	
    	$idPhoto = (int) $request->getParam('id', 0);
    	
    	$photo = models_PhotoMapper::findById($idPhoto);
    	
    	if (null != $idPhoto)
    	{
    		models_PhotoMapper::deleteFromBase($idPhoto, models_PhotoMapper::$_dbTable);
    		
    		if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/photofiles/'.$photo->idPhotoCategories.'/'.$photo->id.'.jpg'))
    		{
    			unlink($_SERVER['DOCUMENT_ROOT'] . '/photofiles/'.$photo->idPhotoCategories.'/'.$photo->id.'.jpg');
    		}
    	}
    	
    	$this->_redirect('/admin/photo');
    }


}

