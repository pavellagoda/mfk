<?php

class CalendarController extends modules_default_controllers_ControllerBase
{

//	public $_contentLayout = 'short';
	
    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	
    	$lastTour = models_TourMapper::getLastAll();
		$idTour = $lastTour->id;
		
		$allTours = models_TourMapper::getAllByTournament(1, false);
		$this->view->allTours = $allTours;
		
		$games = models_GameMapper::findAllByTournament(1);
		$this->view->games = $games;		
		
    	$tourTable = FW_Table::getTable(1, $idTour);
    	$this->view->tourTable = $tourTable;
    	$lastMonolitNews  = models_NewsMapper::findByCategory(1, 10);
    	$this->view->lastMonolitNews = $lastMonolitNews;
    	
    }
}

