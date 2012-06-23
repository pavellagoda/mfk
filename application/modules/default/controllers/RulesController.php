<?php

class RulesController extends modules_default_controllers_ControllerBase
{

//	public $_contentLayout = 'short';
	
    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	$rules = models_RulesMapper::getAll();
    	$this->view->rules = $rules;
    	
//    	throw new Exception();
    }
    public function showAction() 
    {
    	$request = $this->getRequest();
    	$rules = models_RulesMapper::getAll();
    	$this->view->rules = $rules;
    	$link  = $request->getParam('rule');
    	$this->view->rule = models_RulesMapper::findByLink($link);
    }
}

