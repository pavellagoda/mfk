<?php

/**
 * Admin NewscategoryController
 * 
 * @author valery
 * @version 1
 */

class Admin_VideoController extends modules_admin_controllers_ControllerBase
{

    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	$videos = models_VideoMapper::getAll();
    	
    	$this->view->videos = $videos;
    }
    
    public function editAction()
    {
    	$request = $this->getRequest();
    	
    	$idNewsCategory = (int) $request->getParam('id', 0);
    	
    	$newsCategory = models_NewsCategoryMapper::findById($idNewsCategory);
    	
    	if (null == $newsCategory)
    	{
    		$this->_redirect($this->_helper->url('index'));
    	}
    	
    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_NewsCategoryEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$newsCategory->title = $form->getValue('title');

    			models_NewsCategoryMapper::update($newsCategory->id,$newsCategory->toArray(),models_NewsCategoryMapper::$_dbTable);
    			
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}
    	
    	$this->view->newsCategory = $newsCategory;
    }
    
	public function addAction()
    {
    	$request = $this->getRequest();
    	
    	$video = new models_Video();
    	
    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_AddVideoForm();
    		if ($form->isValid($request->getPost()))
    		{
//    			print_r($_SERVER['DOCUMENT_ROOT'] . '/videofiles/videopage/'.$_FILES['file']['name']); die;
    			if($_FILES['file']['type']=='video/x-flv'||$_FILES['file']['type']=='application/octet-stream')
    			{
    				move_uploaded_file($_FILES['file']['tmp_name'], 
							$_SERVER['DOCUMENT_ROOT'] . '/videofiles/videopage/'.$_FILES['file']['name']);
	    			
					$video->title 	= $form->getValue('title');
					$video->viewsCount = 0;
					$video->idVideoCategories 	= $form->getValue('video_categories_id');
    				$video->file 	= $_FILES['file']['name'];
    				
    				
    				if($_FILES['thumb']['type']=='image/jpeg'||$_FILES['thumb']['type']=='image/jpg'||$_FILES['thumb']['type']=='image/png'||$_FILES['thumb']['type']=='image/x-png')
	    			{
	    				move_uploaded_file($_FILES['thumb']['tmp_name'], 
								$_SERVER['DOCUMENT_ROOT'] . '/i/video/'.$_FILES['thumb']['name']);
		    			
	    				$video->thumb 	= $_FILES['thumb']['name'];
	    			}	
							
					models_VideoMapper::save($video);
	    			$this->_redirect('/admin/video');
    			}
    		}
    	}
    	
    	$this->view->videoCategories = models_VideoCategoriesMapper::getAll();
    }
    
	public function deleteAction()
    {
    	$request = $this->getRequest();
    	
    	$idVideo = (int) $request->getParam('id', 0);
    	
    	if ($idVideo != 0)
    	{
    		models_VideoMapper::deleteFromBase($idVideo, models_VideoMapper::$_dbTable);
    	}
    	
    	$this->_redirect('/admin/video');
    }


}

