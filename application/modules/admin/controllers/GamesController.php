<?php

/**
 * Admin GamesController
 * 
 * @author valery
 * @version 1
 */

class Admin_GamesController extends modules_admin_controllers_ControllerBase
{

    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	$request = $this->getRequest();
    	
    	$page = (int) $request->getParam('page', 1);
    	$tour = (int) $request->getParam('tour', 0);
    	
    	$tours = models_TourMapper::getAll();
    	
    	$tournament  = (int) $request->getParam('tounranmentid', 0);
    	
    	
    	if($tournament==0)
    	{
    		$isTournament=false;    	
    		$games = models_GameMapper::getAllPaginator($page, $tour, 30);
    	}
    	else
    	{ 
    		$isTournament=true;    
    		$games = models_GameMapper::findAllByTournamentPage($tournament, $page);
    	}
    	
    	$tournaments = models_TournamentMapper::getAll();
    	
    	$this->view->isTournament = $isTournament;
    	$this->view->tournaments = $tournaments;
    	$this->view->tours = $tours;
    	$this->view->games = $games;
    }
    
    public function editAction()
    {
    	$request = $this->getRequest();
    	
    	$idGame = (int)$request->getParam('id', 0);
    	
    	$game = models_GameMapper::findById($idGame);
    	
    	$news = models_NewsMapper::getAll();
    	
    	if (null == $game)
    	{
    		$this->_redirect($this->_helper->url('index'));
    	}
    	
    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_GameEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$game->completed = $form->getValue('completed') == 'on'?1:0;
    			$game->goals1 = (int)$form->getValue('goals_1')?(int)$form->getValue('goals_1'):0;
    			$game->goals2 = (int)$form->getValue('goals_2')?(int)$form->getValue('goals_2'):0;
    			$game->idTeam1 = $form->getValue('team_id_1');
    			$game->idTeam2 = $form->getValue('team_id_2');
    			$game->newsId = $form->getValue('news_id');
    			$game->sportcomplexId = $form->getValue('sportcomplex_id');
    			$game->completed = $form->getValue('completed');
    			$game->date = $form->getValue('date').' '.$form->getValue('time');

    			models_GameMapper::update($game->id,$game->toArray(),models_GameMapper::$_dbTable);
    			
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}

    	$tours = models_TourMapper::getAll();
    	$teams = models_TeamMapper::getAll();
    	
    	$this->view->places = models_SportcomplexesMapper::getAll();
    	$this->view->news = $news;
    	$this->view->tours = $tours;
    	$this->view->teams = $teams;
    	$this->view->game = $game;
    }
    
	public function createAction()
    {
    	$request = $this->getRequest();
    	
    	$game = new models_Game();
    	
    	$tours = models_TourMapper::getAll();
    	$teams = models_TeamMapper::getAll();
    	$news = models_NewsMapper::getAll();
    	
    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_GameEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$game->completed = $form->getValue('completed') == 'on'?1:0;
    			$game->goals1 = (int)$form->getValue('goals_1');
    			$game->goals2 = (int)$form->getValue('goals_2');
    			$game->idTeam1 = $form->getValue('team_id_1');
    			$game->idTeam2 = $form->getValue('team_id_2');
    			$game->completed = $form->getValue('completed');
    			$game->idTour = $form->getValue('tour_id');
    			$game->newsId = $form->getValue('news_id');
    			$game->sportcomplexId = $form->getValue('sportcomplex_id');
    			$game->date = $form->getValue('date').' '.$form->getValue('time');
    			
    			models_GameMapper::save($game);
    			
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}
    	
    	$this->view->places = models_SportcomplexesMapper::getAll();
    	$this->view->news = $news;
    	$this->view->tours = $tours;
    	$this->view->teams = $teams;
    	$this->view->game = $game;
    }
    
	public function deleteAction()
    {
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	$request = $this->getRequest();
    	
    	$idGame = (int) $request->getParam('id', 0);
    	
    	$game = models_GameMapper::findById($idGame);
    	
    	if (null != $game)
    	{
    		models_GameMapper::deleteFromBase($idGame, models_GameMapper::$_dbTable);
    	}
    	
    	$this->_redirect($this->_helper->url('index'));
    }


}
