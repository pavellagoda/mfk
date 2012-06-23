<?php

/**
 * Admin ToursController
 * 
 * @author valery
 * @version 1
 */

class Admin_PhotoCategoriesController extends modules_admin_controllers_ControllerBase
{

    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	$request = $this->getRequest();
    	
    	$page = (int) $request->getParam('page', 1);
    	
    	$albums = models_PhotoCategoriesMapper::getAllPaginator($page, 100);
    	
    	$this->view->albums = $albums;
    }
    
    public function editAction()
    {
    	$request = $this->getRequest();
    	
    	$id = (int) $request->getParam('id', 0);
    	
    	$album = models_PhotoCategoriesMapper::findById($id);
    	
    	if (null == $album)
    	{
    		$this->_redirect($this->_helper->url('index'));
    	}
    	
    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_PhotoCategoriesEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$album->title = $form->getValue('title');
    			
    			models_PhotoCategoriesMapper::update($album->id,$album->toArray(),models_PhotoCategoriesMapper::$_dbTable);
    			
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}
    	
    	$this->view->album = $album;
    }
    
	public function createAction()
    {
    	$request = $this->getRequest();
    	
    	$album = new models_PhotoCategories();
    	
    	if ($request->isPost())
    	{
    		
    		$form = new modules_admin_forms_PhotoCategoriesEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$album->title = $form->getValue('title');
    			
    			$id = models_PhotoCategoriesMapper::save($album);
    			
    			mkdir($_SERVER['DOCUMENT_ROOT'] .'/photofiles/'.$id, 0777);
    			
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}
    	
    	$this->view->album = $album;
    }
    
	public function deleteAction()
    {
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	$request = $this->getRequest();
    	
    	$id = (int) $request->getParam('id', 0);
    	
    	if (null != $id)
    	{
    		models_PhotoCategoriesMapper::deleteFromBase($id, models_PhotoCategoriesMapper::$_dbTable);
    		
    		rmdir($_SERVER['DOCUMENT_ROOT'] .'/photofiles/'.$id);
    	}
    	
    	$this->_redirect($this->_helper->url('index'));
    }


}

