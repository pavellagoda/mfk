<?php

/**
 * Admin TeamsController
 * 
 * @author valery
 * @version 1
 */

class Admin_ForwardsController extends modules_admin_controllers_ControllerBase
{

    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	
    	$forwards = models_ForwardsMapper::getAll();
    	
    	$this->view->forwards = $forwards;
    }
    
    public function editAction()
    {
    	$request = $this->getRequest();
    	
    	$id = (int) $request->getParam('id', 0);
    	
    	$forward = models_ForwardsMapper::findById($id);
    	
    	if (null == $forward)
    	{
    		$this->_redirect($this->_helper->url('index'));
    	}
    	
    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_ForwardsEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$forward->name = $form->getValue('name');
    			$forward->team = $form->getValue('team');
    			$forward->goals = $form->getValue('goals');
    			$forward->pen = $form->getValue('pen');

    			models_ForwardsMapper::update($forward->id,$forward->toArray(),models_ForwardsMapper::$_dbTable);
    			
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}
    	
    	$this->view->forward = $forward;
    }
    
	public function createAction()
    {
    	$request = $this->getRequest();
    	
    	$forward = new models_Forwards();
    	
    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_ForwardsEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$forward->name = $form->getValue('name');
    			$forward->team = $form->getValue('team');
    			$forward->goals = $form->getValue('goals');
    			$forward->pen = $form->getValue('pen');
    			
    			models_ForwardsMapper::save($forward);
    			
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}
    	
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

