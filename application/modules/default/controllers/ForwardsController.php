<?php

class ForwardsController extends modules_default_controllers_ControllerBase
{

//	public $_contentLayout = 'short';
	
    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    	$this->view->containerClass = "dark_bg";
    }

    public function indexAction()
    {
    	$lastTour = models_TourMapper::getLast(1);
		$idTour = $lastTour->id;
    	$tourTable = FW_Table::getTable(1, $idTour);
    	$this->view->tourTable = $tourTable;
    	$lastMonolitNews  = models_NewsMapper::findByCategory(1, 10);
    	$this->view->lastMonolitNews = $lastMonolitNews;
    	$this->view->forwards = models_ForwardsMapper::getAll();
    }


}

