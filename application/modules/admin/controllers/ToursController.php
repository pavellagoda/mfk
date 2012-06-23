<?php

/**
 * Admin ToursController
 * 
 * @author valery
 * @version 1
 */

class Admin_ToursController extends modules_admin_controllers_ControllerBase
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
    	
    	$tours = models_TourMapper::getAllPaginator($page, 100);
    	
    	$this->view->tours = $tours;
    }
    
    public function editAction()
    {
    	$request = $this->getRequest();
    	
    	$idTour = (int) $request->getParam('id', 0);
    	
    	$tournaments = models_TournamentMapper::getAll();
    	
    	$tour = models_TourMapper::findById($idTour);
    	
    	if (null == $tour)
    	{
    		$this->_redirect($this->_helper->url('index'));
    	}
    	
    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_TourEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$tour->title = $form->getValue('title');
    			
    			$tour->idTournament = $form->getValue('tournament_id');

    			models_TourMapper::update($tour->id,$tour->toArray(),models_TourMapper::$_dbTable);
    			
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}
    	
    	$this->view->tournaments = $tournaments;
    	
    	$this->view->tour = $tour;
    }
    
	public function createAction()
    {
    	$request = $this->getRequest();
    	
    	$tournaments = models_TournamentMapper::getAll();
    	
    	$tour = new models_Tour();
    	
    	if ($request->isPost())
    	{
    		
    		$form = new modules_admin_forms_TourEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$tour->title = $form->getValue('title');
    			
    			$tour->idTournament = $form->getValue('tournament_id');
    			
    			models_TourMapper::save($tour);
    			
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}
    	
    	$this->view->tournaments = $tournaments;
    	
    	$this->view->tour = $tour;
    }
    
	public function deleteAction()
    {
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	$request = $this->getRequest();
    	
    	$idTour = (int) $request->getParam('id', 0);
    	
    	$tour = models_TourMapper::findById($idTour);
    	
    	if (null != $tour)
    	{
    		models_TourMapper::deleteFromBase($idTour, models_TourMapper::$_dbTable);
    	}
    	
    	$this->_redirect($this->_helper->url('index'));
    }


}

