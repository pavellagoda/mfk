<?php

/**
 * TablesController
 * 
 * @author valery
 * @version 1
 */

class TablesController extends modules_default_controllers_ControllerBase
{

	/**
	 * The default action - show the home page
	 */
	public function indexAction()
	{
		$request = $this->getRequest();
		
		$idTour = (int)$request->getParam('id', 0);
		
		$tours = models_TourMapper::getAll();
		
		$games = models_GameMapper::joinArrayByTeam($idTour);
		
		$table= models_TeamMapper::getResultsAtCurrentTour($idTour);

		$this->view->games = $games;
		$this->view->tours = $tours;
		$this->view->table = $table;
		
	}
	
}

