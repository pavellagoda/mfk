<?php

class PhotoController extends modules_default_controllers_ControllerBase
{

//	public $_contentLayout = 'short';
	
    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {

    	$photoCategories = models_PhotoCategoriesMapper::getAll();
    	$this->view->photoCategories = $photoCategories;
    	$this->view->lastPhotos = models_PhotoMapper::getLast(12);
    	$this->view->headScript()->appendFile('/js/lib/funcybox/jquery.fancybox-1.3.1.js');
    	$this->view->headScript()->appendFile('/js/lib/funcybox/jquery.mousewheel-3.0.2.pack.js');
    	$this->view->headScript()->appendFile('/js/fancy.js');
    	$this->view->headLink()->appendStylesheet('/css/fancybox.css');
//    	throw new Exception();
    }
    
	public function categoriesAction()
    {
    	
		$photoCategories = models_PhotoCategoriesMapper::getAll();
    	$this->view->photoCategories = $photoCategories;
    	
    	$request = $this->getRequest();
    	
    	$id = $request->getParam('id');
    	
    	$page =  $request->getParam('page');
    	
    	$this->view->lastPhotos = models_PhotoMapper::getAllByCategoriesPage($id, $page);
    	
//    	print_r($this->view->lastPhotos); die;
    	
    	$this->view->headScript()->appendFile('/js/lib/funcybox/jquery.fancybox-1.3.1.js');
    	$this->view->headScript()->appendFile('/js/lib/funcybox/jquery.mousewheel-3.0.2.pack.js');
    	$this->view->headScript()->appendFile('/js/fancy.js');
    	$this->view->headLink()->appendStylesheet('/css/fancybox.css');
    	
    }
    
}

