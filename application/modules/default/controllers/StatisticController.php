<?php

class StatisticController extends modules_default_controllers_ControllerBase
{

//	public $_contentLayout = 'short';

    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function showAction()
    {
    	$request = $this->getRequest();

    	$groupSlug = $request->getParam('tour');
    	$year = $request->getParam('year');

    	$group = models_StatGroupMapper::findBySlug($groupSlug);

    	$page = models_StatYearMapper::findByYearAndGroup($year, $group->id);

    	$this->view->page = $page;
    	
    	$lastMonolitNews  = models_NewsMapper::findByCategory(1, 10);
    	$this->view->lastMonolitNews = $lastMonolitNews;

//    	$this->view->folder = $request->getParam('tour');
//    	$this->view->file = $request->getParam('year');
//    	throw new Exception();
    }
}

