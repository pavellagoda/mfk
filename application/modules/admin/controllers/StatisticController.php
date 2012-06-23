<?php

/**
 * Admin StatisticController
 *
 * @author valery
 * @version 1
 */

class Admin_StatisticController extends modules_admin_controllers_ControllerBase
{

    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	$request = $this->getRequest();

    	$statGroups = models_StatGroupMapper::getAll();
		$this->view->statGroups = $statGroups;
		$statYears = models_StatYearMapper::getAll();
		$this->view->statYears = $statYears;
    }

    public function edityearAction()
    {
    	$request = $this->getRequest();

    	$idYear = (int) $request->getParam('id', 0);

    	$yearItem = models_StatYearMapper::findById($idYear);

    	if (null == $yearItem)
    	{
    		$this->_redirect($this->_helper->url('index'));
    	}

    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_StatisticEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$yearItem->title = $form->getValue('title');
    			$yearItem->year = $form->getValue('year');
    			$yearItem->content = $form->getValue('content');
    			
//    			print_r($yearItem->content); die;

    			models_StatYearMapper::update($yearItem->id,$yearItem->toArray(),models_StatYearMapper::$_dbTable);

    			$this->_redirect($this->_helper->url('index'));
    		}
    	}

    	$this->view->headScript()->appendFile('/ckeditor/ckeditor.js');
    	$this->view->headScript()->appendFile('/ckfinder/ckfinder.js');

    	$this->view->yearItem = $yearItem;
    }

    public function createyearAction()
    {
    	$request = $this->getRequest();

    	$idParent = (int) $request->getParam('parentid', 0);

    	$yearItem = new models_StatYear();

    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_StatisticEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    		    $yearItem->idStatGroup = $idParent;
    			$yearItem->title = $form->getValue('title');
    			$yearItem->year = $form->getValue('year');
    			$yearItem->content = $form->getValue('content');

    			models_StatYearMapper::save($yearItem);

    			$this->_redirect($this->_helper->url('index'));
    		}
    	}

    	$this->view->headScript()->appendFile('/ckeditor/ckeditor.js');
    	$this->view->headScript()->appendFile('/ckfinder/ckfinder.js');
    }

	public function deleteyearAction()
    {
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	$request = $this->getRequest();

    	$idYear = (int) $request->getParam('id', 0);

    	$yearItem = models_StatYearMapper::findById($idYear);

    	if (null != $yearItem)
    	{
    		models_StatYearMapper::deleteFromBase($idYear, models_StatYearMapper::$_dbTable);
    	}

    	$this->_redirect($this->_helper->url('index'));
    }

    public function editgroupAction()
    {
    	$request = $this->getRequest();

    	$idGroup = (int) $request->getParam('id', 0);

    	$groupItem = models_StatGroupMapper::findById($idGroup);

    	if (null == $groupItem)
    	{
    		$this->_redirect($this->_helper->url('index'));
    	}

    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_StatisticGroupEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$groupItem->title = $form->getValue('title');
    			$groupItem->slug = $form->getValue('slug');

    			models_StatGroupMapper::update($groupItem->id,$groupItem->toArray(),models_StatGroupMapper::$_dbTable);

    			$this->_redirect($this->_helper->url('index'));
    		}
    	}

    	$this->view->headScript()->appendFile('/ckeditor/ckeditor.js');
    	$this->view->headScript()->appendFile('/ckfinder/ckfinder.js');

    	$this->view->groupItem = $groupItem;
    }

    public function creategroupAction()
    {
    	$request = $this->getRequest();

    	$idGroup = (int) $request->getParam('parentid', 0);

    	$parentItem = models_StatGroupMapper::findById($idGroup);

    	if (0 != $idGroup && null == $parentItem)
    	{
    		$this->_redirect($this->_helper->url('index'));
    	}

    	$groupItem = new models_StatGroup();

    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_StatisticGroupEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$groupItem->title = $form->getValue('title');
    			$groupItem->slug = $form->getValue('slug');
    			$groupItem->idParent = $idGroup;

    			models_StatGroupMapper::save($groupItem);

    			$this->_redirect($this->_helper->url('index'));
    		}
    	}

    	$this->view->headScript()->appendFile('/ckeditor/ckeditor.js');
    	$this->view->headScript()->appendFile('/ckfinder/ckfinder.js');

    	$this->view->groupItem = $groupItem;
    }

    public function deletegroupAction()
    {
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	$request = $this->getRequest();

    	$idGroup = (int) $request->getParam('id', 0);

    	$groupItem = models_StatGroupMapper::findById($idGroup);

    	if (null != $groupItem)
    	{
    		models_StatGroupMapper::deleteFromBase($idGroup, models_StatGroupMapper::$_dbTable);
    	}

    	$this->_redirect($this->_helper->url('index'));
    }

}

