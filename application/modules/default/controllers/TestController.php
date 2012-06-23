<?php

class TestController extends modules_default_controllers_ControllerBase
{

//	public $_contentLayout = 'short';

    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {

		$test = 'test-message';
		$toEcho = "'$test'";
    	
    	print_r($toEcho); die;
    	
    }
}

