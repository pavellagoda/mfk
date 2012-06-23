<?php

class AcademyController extends modules_default_controllers_ControllerBase
{

//	public $_contentLayout = 'short';
	
    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	
    	$lastTour = models_TourMapper::getLast();
		$idTour = $lastTour->id;
    	$tourTable = FW_Table::getTable(1, $idTour);
    	$this->view->tourTable = $tourTable;
    	$lastMonolitNews  = models_NewsMapper::findByCategory(1, 6);
    	$this->view->lastMonolitNews = $lastMonolitNews;
    	
    }
}

