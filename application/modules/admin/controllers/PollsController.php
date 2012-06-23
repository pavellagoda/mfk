<?php

/**
 * Admin PollsController
 * 
 * @author valery
 * @version 1
 */

class Admin_PollsController extends modules_admin_controllers_ControllerBase
{

	public function init ()
	{
		/* Initialize action controller here */
		parent::init();
	}

	public function indexAction ()
	{
		$request = $this->getRequest();
		
		$page = (int) $request->getParam('page', 1);
		
		$polls = models_PollMapper::getAllPaginator($page);
		
		$this->view->polls = $polls;
	}

	public function editAction ()
	{
		$request = $this->getRequest();
		
		$idPoll = (int) $request->getParam('id', 0);
		
		$poll = models_PollMapper::findById($idPoll);
		
		if (null == $poll)
		{
			$this->_redirect($this->_helper->url('index'));
		}
		
		if ($request->isPost())
		{
			$form = new modules_admin_forms_PollEditForm();
			if ($form->isValid($request->getPost()))
			{
				$poll->question = $form->getValue('question');
				$poll->active = $form->getValue('active') == 'on'?1:0;
				
				models_PollMapper::update($poll->id, $poll->toArray(), 
						models_PollMapper::$_dbTable);
				
				$this->_redirect($this->_helper->url('index'));
			}
		}
		
		$this->view->poll = $poll;
	}

	public function createAction ()
	{
		$request = $this->getRequest();
		
		$poll = new models_Poll();
		
		if ($request->isPost())
		{
			$form = new modules_admin_forms_PollEditForm();
			if ($form->isValid($request->getPost()))
			{
				$poll->question = $form->getValue('question');
				$poll->active = $form->getValue('active') == 'on'?1:0;
				
				models_PollMapper::save($poll);
				
				$this->_redirect($this->_helper->url('index'));
			}
		}
		
		$this->view->poll = $poll;
	}

	public function deleteAction ()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
		$request = $this->getRequest();
		
		$idPoll = (int) $request->getParam('id', 0);
		
		$poll = models_PollMapper::findById($idPoll);
		
		if (null != $poll)
		{
			models_PollMapper::deleteFromBase($idPoll, 
					models_PollMapper::$_dbTable);
		}
		
		$this->_redirect($this->_helper->url('index'));
	}

}

