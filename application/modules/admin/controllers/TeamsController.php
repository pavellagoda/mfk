<?php

/**
 * Admin TeamsController
 * 
 * @author valery
 * @version 1
 */

class Admin_TeamsController extends modules_admin_controllers_ControllerBase
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
    	
    	$teams = models_TeamMapper::getAllPaginator($page, 100500);
    	
    	$this->view->teams = $teams;
    }
    
    public function editAction()
    {
    	$request = $this->getRequest();
    	
    	$idTeam = (int) $request->getParam('id', 0);
    	
    	$team = models_TeamMapper::findById($idTeam);
    	
    	if (null == $team)
    	{
    		$this->_redirect($this->_helper->url('index'));
    	}
    	
    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_TeamEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$team->title = $form->getValue('title');

    			models_TeamMapper::update($team->id,$team->toArray(),models_TeamMapper::$_dbTable);
    			
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}
    	
    	$this->view->team = $team;
    }
    
	public function createAction()
    {
    	$request = $this->getRequest();
    	
    	$team = new models_Team();
    	
    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_TeamEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$team->title = $form->getValue('title');
    			
    			models_TeamMapper::save($team);
    			
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}
    	
    	$this->view->team = $team;
    }
    
	public function deleteAction()
    {
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	$request = $this->getRequest();
    	
    	$idTeam = (int) $request->getParam('id', 0);
    	
    	$team = models_TeamMapper::findById($idTeam);
    	
    	if (null != $team)
    	{
    		models_TeamMapper::deleteFromBase($idTeam, models_TeamMapper::$_dbTable);
    	}
    	
    	$this->_redirect($this->_helper->url('index'));
    }


}

