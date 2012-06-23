<?php

class ChatController extends modules_default_controllers_ControllerBase
{

	public $ajaxable = array(
		'list' => array('json'),
		'post' => array('json'),
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
    	$this->_redirect('/');
    }
    
    public function listAction()
    {
    	$chats = models_ChatMapper::getLast();
    	
    	$items = array();
    	
    	foreach ($chats as $item)
    	{
    		$items[] = array(
    			'name' => $item->name,
    			'text' => $item->text,
    			'time' => FW_Date::convert($item->createdTs, FW_Date::MYSQL_DATETIME, FW_Date::SITE_TIME)
    		);
    	}
    	
    	$this->view->chats = $items;
    }

    public function postAction()
    {
    	$request = $this->getRequest();
    	
    	if ($request->isPost())
    	{
    		$form = new modules_default_forms_ChatForm();
    		if ($form->isValid($request->getPost()))
    		{
    			$chat = new models_Chat();
    			
    			$chat->name = $form->getValue('name');
    			$chat->text = $form->getValue('text');
    			
    			models_ChatMapper::save($chat);
    		}
    	}
    	
    	$chats = models_ChatMapper::getLast();
    	
    	$items = array();
    	
    	foreach ($chats as $item)
    	{
    		$items[] = array(
    			'name' => $item->name,
    			'text' => $item->text,
    			'time' => FW_Date::convert($item->createdTs, FW_Date::MYSQL_DATETIME, FW_Date::SITE_TIME)
    		);
    	}
    	
    	$this->view->chats = $items;
    }

}

