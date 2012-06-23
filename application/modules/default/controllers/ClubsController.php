<?php

class ClubsController extends modules_default_controllers_ControllerBase
{

//	public $_contentLayout = 'short';
	
    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
		$lastMonolitNews  = models_NewsMapper::findByCategory(1, 10);
    	$this->view->lastMonolitNews = $lastMonolitNews;
    	
    	$clubs = models_ClubsMapper::getAll();
    	
    	$this->view->clubs = $clubs;
    }
    
	public function showAction()
    {
		$lastMonolitNews  = models_NewsMapper::findByCategory(1, 10);
    	$this->view->lastMonolitNews = $lastMonolitNews;
    	
    	$request = $this->getRequest();
    	
    	$idClub = (int)$request->id;
    	
    	$club = models_ClubsMapper::findById($idClub);
    	
    	$this->view->club = $club;
    }
}

