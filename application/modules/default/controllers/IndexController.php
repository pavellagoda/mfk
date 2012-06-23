<?php

/**
 * NewsController
 *
 * @author valery
 * @version 1
 */

class IndexController extends modules_default_controllers_ControllerBase
{

    public $ajaxable = array(
		'refresh-captcha' => array('json'),
	);

	public function init()
	{
		if (! $this->getRequest()->isXmlHttpRequest())
		{
			parent::init();
		}

		$this->_helper->AjaxContext()->initContext('json');

	}
	public function indexAction()
	{
		$categoryLeft = models_NewsCategoryMapper::findById(1);
		$categoryRight = models_NewsCategoryMapper::findById(2);

		$lastNews = models_NewsMapper::getLast(6);

		$newIds = array();

		foreach ($lastNews as $lastNew)
		{
			$newIds[]=$lastNew->id;
		}

		$request = $this->getRequest();

		$leftNewsPage = (int) $request->getParam('lpage', 1);
		$rightNewsPage = (int) $request->getParam('rpage', 1);

		$newsLeft = models_NewsMapper::findByCategoryPage($categoryLeft->id, $leftNewsPage,7,$newIds);
		$newsRight = models_NewsMapper::findOthersPage($categoryLeft->id, $rightNewsPage,7,$newIds);


//		$paginator=models_NewsMapper::findByCategoryPage ($idCategory, $page)

		$poll = models_PollMapper::getActive();
		if (null != $poll)
		{
			$pollVariants = models_PollVariantMapper::findByPollId($poll->id);
			$this->view->poll = $poll;
			$this->view->pollVariants = $pollVariants;
			$votedPolls = models_PollAnswerMapper::getVotedPolls(FW_User::getLoggedUserId());

			$this->view->votedPolls = $votedPolls;
		}

		$forwards = models_ForwardsMapper::getAll(5);

		$lastTour = models_TourMapper::getLast(1);
		$idTour = $lastTour->id;

		$lastGames = models_GameMapper::joinArrayByTeam($idTour);

		$tourTable=  FW_Table::getTable(1, $idTour);

		$videos = models_VideoMapper::getLast();

		$nextTour = models_TourMapper::getFirstPending();

                $this->view->nextTour = $nextTour?models_GameMapper::joinArrayByTeam($nextTour->id):null;
		
		$this->view->sportua = models_ForeignNewsMapper::getLast(10);
		
		$this->view->videos = $videos;

		$this->view->forwards = $forwards;

		$this->view->lastGames = $lastGames;

		$this->view->tourTable = $tourTable;

		$this->view->newsLeft = $newsLeft;
		$this->view->newsRight = $newsRight;

		$this->view->lastNews = $lastNews;

		$this->view->categoryLeft = $categoryLeft;
		$this->view->categoryRight = $categoryRight;

	}

	public function tagAction ()
	{
		$request = $this->getRequest ();
		$id = $request->getParam ('id');

		$tag = models_TagsMapper::findById($id);
		if (null == $tag)
		{
			$this->_redirect($this->_helper->url('index'));
		}

		$allNews = models_NewsMapper::findByTagId ($id, $request->getParam ('lpage'), 10);
//		print_r ($allNews);
		$this->view->tag = $tag;
		$this->view->allNews = $allNews;
	}

	public function viewAction()
	{
		$request = $this->getRequest();

		$idNews = (int) $request->getParam('id', 0);

		$newsItem = models_NewsMapper::findById($idNews);
		
		if (null == $newsItem)
		{
			$this->_redirect($this->_helper->url('index'));
		}
		
		models_NewsMapper::incrementViewsCount($idNews);

		$tags = models_TagsMapper::findByNewsId($idNews);

		$form = new modules_default_forms_CommentForm();

		if ($request->isPost())
		{
			if ($form->isValid($request->getPost()))
			{
				$comment = new models_Comment();

				$comment->idNews = $newsItem->id;
				$comment->idUser = FW_User::getLoggedUserId();
				$comment->name = null;
				$comment->text = $form->getValue('text');
				models_CommentMapper::save($comment);
			}
			else
			{
				$this->view->formErrors = $form->getErrors();
			}
		}

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


                $page = (int)$request->getParam('page', 1);
		$comments = models_CommentMapper::getAllPaginator($idNews, $page);

		$idTournament = $request->getParam('tournamentid',1);

		$lastTour = models_TourMapper::getLast($idTournament);
		if(null==$lastTour)
			$lastTour = models_TourMapper::getLastAll($idTournament);

		$idTour = $lastTour->id;

		$nextTour = models_TourMapper::getFirstPending();
		
		$this->view->nextTour = $nextTour?models_GameMapper::joinArrayByTeam($nextTour->id):null;

		$lastGames = models_GameMapper::joinArrayByTeam($idTour);

		$tourTable = FW_Table::getTable($idTournament, $idTour);

		$this->view->lastGames = $lastGames;

		$this->view->tourTable = $tourTable;

		$this->view->captcha = $form->captcha;
		$this->view->comments = $comments;
		$this->view->newsItem = $newsItem;

		$this->view->tournament = models_TournamentMapper::findById($idTournament);

		$lastMonolitNews  = models_NewsMapper::findByCategory(1, 10);
    	$this->view->lastMonolitNews = $lastMonolitNews;
	}

	public function refreshCaptchaAction() {
		$form = new modules_default_forms_CommentForm();
		$this->view->captcha = $form->captcha->getCaptcha()->generate();
	}

}

