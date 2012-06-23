<?php

/**
 * Admin StatisticController
 *
 * @author valery
 * @version 1
 */

class Admin_ArchivController extends modules_admin_controllers_ControllerBase
{

    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
		$archivs = models_ArchivMapper::getAll();
    	$this->view->archivs = $archivs;
    }

    public function editAction()
    {
    	$request = $this->getRequest();

    	$id = (int) $request->getParam('id', 0);
    	

    	$archiv = models_ArchivMapper::findById($id);

    	if (null == $archiv)
    	{
    		$this->_redirect($this->_helper->url('index'));
    	}

    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_ArchivEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$archiv->content 	= $form->getValue('content');
    			
    			models_StatYearMapper::update($archiv->id,$archiv->toArray(),models_ArchivMapper::$_dbTable);

    			$this->_redirect($this->_helper->url('index'));
    		}
    	}

    	$this->view->headScript()->appendFile('/ckeditor/ckeditor.js');
    	$this->view->headScript()->appendFile('/ckfinder/ckfinder.js');

    	$this->view->archiv = $archiv;
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

