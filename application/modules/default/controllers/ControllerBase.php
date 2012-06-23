<?php
class modules_default_controllers_ControllerBase extends controllers_ControllerBase
{

	/**
	 * Set content layout (full, short)
	 * @var string
	 */
	public $_contentLayout = 'full';
	protected $_bForLoggedUsersOnly = false;

	protected $isTopBaner = true;

	public function init()
	{
		parent::init();
		
		if (! FW_User::isLogged() && $this->_bForLoggedUsersOnly)
		{
			$this->_redirect('/login/');
		}
		

		$oZendSession = Zend_Registry::getInstance()->get('Zend_Session_Namespace');


		$statGroups = models_StatGroupMapper::getAll();
		$this->view->statGroups = $statGroups;
		$statYears = models_StatYearMapper::getAll();
		$this->view->statYears = $statYears;

		$this->view->headLink()->appendStylesheet('/css/common/reset.css');
		$this->view->headLink()->appendStylesheet('/css/common/960.css');
		$this->view->headLink()->appendStylesheet('/css/front/main.css');
		$this->view->headLink()->appendStylesheet('/css/front/menu.css');
		$this->view->headLink()->appendStylesheet('/css/common/sexybuttons.css');

		$this->view->headScript()->appendFile('/js/global.js');
		$this->view->headScript()->appendFile('/js/menu.js');
		$this->view->headTitle()->setSeparator(' / ');
		
		$frontController 			= Zend_Controller_Front::getInstance();
		$this->view->controllerName = $frontController->getRequest()->getControllerName();
		$this->view->actionName 	= $frontController->getRequest()->getActionName();

		$this->view->siteName = 'МФК Монолит';

		$this->view->isTopBaner = $this->isTopBaner;
		
		$this->view->loggedUser = FW_User::getLoggedUser(); 
	}

}

