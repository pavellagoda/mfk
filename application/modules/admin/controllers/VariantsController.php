<?php

/**
 * Admin VariantsController
 * 
 * @author valery
 * @version 1
 */

class Admin_VariantsController extends modules_admin_controllers_ControllerBase
{

	public function init ()
	{
		/* Initialize action controller here */
		parent::init();
		
		$request = $this->getRequest();
		$idPoll = (int) $request->getParam('poll', 0);
		
		$poll = models_PollMapper::findById($idPoll);
		
		if (null == $poll)
			$this->_redirect($this->view->url(array('controller'=>'polls', 'action' => 'index', 'id'=>null, 'poll'=>null)));
	}

	public function indexAction ()
	{
		$request = $this->getRequest();
		
		$page = (int) $request->getParam('page', 1);
		$idPoll = (int) $request->getParam('poll', 0);
		
		$variants = models_PollVariantMapper::getAllPaginator($page, $idPoll);
		
		$this->view->variants = $variants;
	}

	public function editAction ()
	{
		$request = $this->getRequest();
		
		$idVariant = (int) $request->getParam('id', 0);
		
		$variant = models_PollVariantMapper::findById($idVariant);
		
		if (null == $variant)
		{
			$this->_redirect($this->_helper->url('index'));
		}
		
		if ($request->isPost())
		{
			$form = new modules_admin_forms_PollVariantEditForm();
			if ($form->isValid($request->getPost()))
			{
				$variant->text = $form->getValue('text');
				
				models_PollVariantMapper::update($variant->id,$variant->toArray(),models_PollVariantMapper::$_dbTable);
				
				$this->_redirect($this->view->url(array('action'=>'index')));
			}
		}
		
		$this->view->variant = $variant;
	}

	public function createAction ()
	{
		$request = $this->getRequest();
		
		$idPoll = (int) $request->getParam('poll', 0);
		
		$variant = new models_PollVariant();
		
		if ($request->isPost())
		{
			$form = new modules_admin_forms_PollVariantEditForm();
			if ($form->isValid($request->getPost()))
			{
				$variant->text = $form->getValue('text');
				$variant->idPoll = $idPoll;
				
				models_PollVariantMapper::save($variant);
				
				$this->_redirect($this->view->url(array('action'=>'index')));
			}
		}
		
		$this->view->variant = $variant;
	}

	public function deleteAction ()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
		$request = $this->getRequest();
		
		$idVariant = (int) $request->getParam('id', 0);
		
		$variant = models_PollVariantMapper::findById($idVariant);
		
		if (null != $variant)
		{
			models_PollVariantMapper::deleteFromBase($idVariant, 
					models_PollVariantMapper::$_dbTable);
		}
		
		$this->_redirect($this->_helper->url('index'));
	}

}

