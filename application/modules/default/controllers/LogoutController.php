<?php

class LogoutController extends modules_default_controllers_ControllerBase
{

    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	if (FW_User::isLogged())
    	{
    		FW_User::logout();
    	}
    	$this->_redirect('/');
    }


}

