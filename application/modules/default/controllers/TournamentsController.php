<?php

class TournamentsController extends modules_default_controllers_ControllerBase
{

//	public $_contentLayout = 'short';
	
    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	
//    	throw new Exception();
    }
    
	public function showAction()
    {
    	
    	$this->view->headScript()->appendFile('/js/tournaments.js');
    	
    	$request = $this->getRequest();

		$leftNewsPage = (int) $request->getParam('lpage', 1);
		$rightNewsPage = (int) $request->getParam('rpage', 1);
    	
    	
    	$categoryLeft = models_NewsCategoryMapper::findById(1);
		$categoryRight = models_NewsCategoryMapper::findById(2);
		
		$newsTag = (int) $request->getParam('tag', 9);
		
		$lastNews = models_NewsMapper::findByTagId($newsTag,1,6);

//		$lastNews = models_NewsMapper::getLast(6);

		$newIds = array();

		foreach ($lastNews as $lastNew)
		{
			$newIds[]=$lastNew['id'];
		}
		

		$newsLeft = models_NewsMapper::findByCategoryPage($categoryLeft->id, $leftNewsPage, 6, $newIds);
		$newsRight = models_NewsMapper::findOthersPage($categoryLeft->id, $rightNewsPage,6, $newIds);

//		$page=3;

//		$paginator=models_NewsMapper::findByCategoryPage ($idCategory, $page)

		$poll = models_PollMapper::getActive();
		if (null != $poll)
		{
			$pollVariants = models_PollVariantMapper::findByPollId($poll->id);
			$this->view->poll = $poll;
			$this->view->pollVariants = $pollVariants;
			$session = Zend_Registry::get('Zend_Session_Namespace');
			if (null == $session->votedPolls) {
			    $session->votedPolls = array();
			}
			
			$this->view->votedPolls = $session->votedPolls;
		}
		
		$tournamentId = (int) $request->getParam('tournamentid');
		
		$forwards = null;
		if($tournamentId==1)
			$forwards = models_ForwardsMapper::getAll(5);
		
		$allTours = models_TourMapper::getAllByTournament($tournamentId);
		
//		print_r($allTours); die;
		
		if(null==(int) $request->getParam('idtour'))
		{
			$lastTour = models_TourMapper::getLast($tournamentId);
			
			if(null==$lastTour)
				$lastTour = models_TourMapper::getLastAll($tournamentId);
			
			$idTour = $lastTour->id;
			
		} else {
			
			$idTour = (int) $request->getParam('idtour');
			
		}
		
		
		$nextTour = models_TourMapper::getFirstPending($tournamentId);
		
		if($nextTour)
			$this->view->nextTour = models_GameMapper::joinArrayByTeam($nextTour->id);
		
		$lastGames = models_GameMapper::joinArrayByTeam($idTour);
		
		$tourTable=  FW_Table::getTable($tournamentId, $idTour);


		$videos = models_VideoMapper::getLast();

		$this->view->videos = $videos;
		
		$this->view->forwards = $forwards;

		$this->view->lastGames = $lastGames;
		
		$this->view->allTours = $allTours;

		$this->view->tourTable = $tourTable;

		$this->view->newsLeft = $newsLeft;
		$this->view->newsRight = $newsRight;
		
		$this->view->tournament = models_TournamentMapper::findById($tournamentId);

		$this->view->lastNews = $lastNews;

		$this->view->categoryLeft = $categoryLeft;
		$this->view->categoryRight = $categoryRight;
		
		$this->view->tag = models_TagsMapper::findById($newsTag);
		
//		print_r($this->view->tag); die;
		
		$this->view->idTour = $idTour;
    	
    }
    
}

