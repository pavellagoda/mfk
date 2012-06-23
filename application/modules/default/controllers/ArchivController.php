<?php

class ArchivController extends modules_default_controllers_ControllerBase
{

//	public $_contentLayout = 'short';

    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function showAction()
    {
    	$request = $this->getRequest();

    	$id = $request->getParam('id');

    	$this->view->page = models_ArchivMapper::findById($id);
    	
    	$lastMonolitNews  = models_NewsMapper::findByCategory(1, 10);
    	$this->view->lastMonolitNews = $lastMonolitNews;

    }
}

