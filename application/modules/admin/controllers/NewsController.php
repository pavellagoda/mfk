<?php

/**
 * Admin NewsController
 * 
 * @author valery
 * @version 1
 */

class Admin_NewsController extends modules_admin_controllers_ControllerBase
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
    	
    	$category = (int) $request->getParam('category', 0);
    	
    	$news = models_NewsMapper::getAllPaginator($category, $page);
    	
    	$this->view->news = $news;
    }
    
    public function editAction()
    {
    	$request = $this->getRequest();
    	
    	$idNews = (int) $request->getParam('id', 0);
    	
    	$newsItem = models_NewsMapper::findById($idNews);
    	
    	$newsCategories = models_NewsCategoryMapper::getAll();
    	
    	$newsRubrics = models_TagsMapper::getAll ();
    	
    	$newsRubricsLinks = models_NewsTagsMapper::findByNewsId($idNews);
    	
    	$items = array();
    	foreach ($newsRubricsLinks as $item)
    	{
    		$items[] = $item->idTag;
    	}
    	$newsRubricsLinks = $items;
    	unset($items);
    	
    	if (null == $newsItem)
    	{
    		$this->_redirect($this->_helper->url('index'));
    	}
    	
    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_NewsEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$newsItem->title = $form->getValue('title');
    			$newsItem->idNewsCategory = $form->getValue('category');
    			$newsItem->short = $form->getValue('short');
    			$newsItem->full = $form->getValue('full');
    			$newsItem->type = $form->getValue('type');

    			$allowedMimes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/pjpeg', 'image/x-png');
				if ($_FILES['icon']['error'] == 0 && in_array($_FILES['icon']['type'], $allowedMimes))
				{
					$imgtype = explode(".", $_FILES['icon']['name']);
					$imgext = $imgtype[count($imgtype) - 1];
					$filename = '/newsicons/' . $newsItem->id . '.' . $imgext;
					move_uploaded_file(
									$_FILES['icon']['tmp_name'], 
									$_SERVER['DOCUMENT_ROOT'] . $filename);
					$newsItem->customIcon = $filename;
				}
    			models_NewsMapper::update($newsItem->id,$newsItem->toArray(),models_NewsMapper::$_dbTable);
    			
    			models_NewsTagsMapper::deleteByNewsId($idNews);
    			
    			$tags = $form->getValue('tags');
    			
    			foreach($tags as $tag)
    			{
    				$newstags = new models_NewsTags();
    				$newstags->idNews = $idNews;
    				$newstags->idTag = $tag;
    				models_NewsTagsMapper::save($newstags);
    			}
    			
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}
    	
    	$this->view->headScript()->appendFile('/js/tiny_mce/tiny_mce.js');
        $this->view->headScript()->appendFile('/js/texteditor.js');
    	
    	$this->view->newsItem = $newsItem;
    	$this->view->newsCategories = $newsCategories;
    	$this->view->newsRubrics = $newsRubrics;
    	$this->view->newsRubricsLinks = $newsRubricsLinks;
    }
    
	public function createAction()
    {
    	$request = $this->getRequest();
    	
    	$newsItem = new models_News();
    	$newsCategories = models_NewsCategoryMapper::getAll();
    	$newsRubrics = models_TagsMapper::getAll ();
    	
    	if ($request->isPost())
    	{
    		$form = new modules_admin_forms_NewsEditForm();
    		if ($form->isValid($request->getPost()))
    		{
    			
    			$newsItem->title = $form->getValue('title');
    			$newsItem->idNewsCategory = $form->getValue('category');
    			$newsItem->short = $form->getValue('short');
    			$newsItem->full = $form->getValue('full');
    			$newsItem->type = $form->getValue('type');
    			$newsItem->viewsCount = 0;
    			
    			$idNews = models_NewsMapper::save($newsItem);
    			$newsItem = models_NewsMapper::findById($idNews);
    			
    			$allowedMimes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/pjpeg', 'image/x-png');
				if ($_FILES['icon']['error'] == 0 && in_array($_FILES['icon']['type'], $allowedMimes))
				{
					$imgtype = explode(".", $_FILES['icon']['name']);
					$imgext = $imgtype[count($imgtype) - 1];
					$filename = '/newsicons/' . $idNews . '.' . $imgext;
					move_uploaded_file(
									$_FILES['icon']['tmp_name'], 
									$_SERVER['DOCUMENT_ROOT'] . $filename);
					$newsItem->customIcon = $filename;
				}
				
				models_NewsMapper::update($newsItem->id,$newsItem->toArray(),models_NewsMapper::$_dbTable);
    			
    			$tags = $form->getValue('tags');
    			
    			foreach($tags as $tag)
    			{
    				$newstags = new models_NewsTags();
    				$newstags->idNews = $newsItem->id;
    				$newstags->idTag = $tag;
    				models_NewsTagsMapper::save($newstags);
    			}
				
    			$this->_redirect($this->_helper->url('index'));
    		}
    	}
    	
    	$this->view->headScript()->appendFile('/js/tiny_mce/tiny_mce.js');
        $this->view->headScript()->appendFile('/js/texteditor.js');
    	
    	$this->view->newsItem = $newsItem;
    	$this->view->newsCategories = $newsCategories;
//    	print_r ($newsRubrics); die;
    	$this->view->newsRubrics = $newsRubrics;
    }
    
	public function deleteAction()
    {
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	$request = $this->getRequest();
    	
    	$idNews = (int) $request->getParam('id', 0);
    	
    	$newsItem = models_NewsMapper::findById($idNews);
    	
    	if (null != $newsItem)
    	{
    		if (file_exists($_SERVER['DOCUMENT_ROOT'] . $newsItem->customIcon))
    		{
    			unlink($_SERVER['DOCUMENT_ROOT'] . $newsItem->customIcon);
    		}
    		models_NewsMapper::deleteFromBase($idNews, models_NewsMapper::$_dbTable);
    	}
    	
    	$this->_redirect($this->_helper->url('index'));
    }


}

