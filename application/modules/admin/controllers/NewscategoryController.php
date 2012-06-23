<?php

/**
 * Admin NewscategoryController
 * 
 * @author valery
 * @version 1
 */

class Admin_NewscategoryController extends modules_admin_controllers_ControllerBase
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
    	
    	$newsCategories = models_TagsMapper::getAllPaginator($page);
    	
    	$this->view->newsCategories = $newsCategories;
    }
    
    public function editAction()
    {
    	$request = $this->getRequest();
    	
    	$idNewsCategory = (int) $request->getParam('id', 0);
    	
    	$newsCategory = models_TagsMapper::findById($idNewsCategory);
    	
    	if (null == $newsCategory)
    	{
    		$this->_redirect($this->_helper->url('index'));
    	}
    	
    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_NewsCategoryEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$newsCategory->name = $form->getValue('name');

    			models_TagsMapper::update($newsCategory->id,$newsCategory->toArray(),models_TagsMapper::$_dbTable);
    			
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}
    	
    	$this->view->newsCategory = $newsCategory;
    }
    
	public function createAction()
    {
    	$request = $this->getRequest();
    	
    	$newsCategory = new models_Tags();
    	
    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_NewsCategoryEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$newsCategory->name = $form->getValue('name');
    			
    			models_TagsMapper::save($newsCategory);
    			
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}
    	
    	$this->view->newsCategory = $newsCategory;
    }
    
	public function deleteAction()
    {
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	$request = $this->getRequest();
    	
    	$idNewsCategory = (int) $request->getParam('id', 0);
    	
    	$newsCategory = models_TagsMapper::findById($idNewsCategory);
    	
    	if (null != $newsCategory)
    	{
    		models_TagsMapper::deleteFromBase($idNewsCategory, models_TagsMapper::$_dbTable);
    	}
    	
    	$this->_redirect($this->_helper->url('index'));
    }


}

