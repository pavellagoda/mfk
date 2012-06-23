<?php

class RegisterController extends modules_default_controllers_ControllerBase
{

	public $_contentLayout = 'short';
	
    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	if (FW_User::isLogged())
    	{
    		$this->_redirect('/');
    	}
    	
    	$form = new modules_default_forms_RegisterForm();
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost())
    	{
    		if ($form->isValid($request->getPost()))
    		{
//    			print_r($request->getPost()); die;
    			FW_User::register($request->getPost());
    			if (FW_User::isLogged())
    			{
    				$this->_redirect('/');
    			}
    			else
    			{
    				
    			}
    		} else {
    			$form->populate(array());
    		}
    	}
    	
    	$this->view->form = $form;
    }


}

