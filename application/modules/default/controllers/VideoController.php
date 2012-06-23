<?php

class VideoController extends modules_default_controllers_ControllerBase
{

    public $ajaxable = array(
		'listcomments' => array('json'),
		'postcomment' => array('json'),
	);
//	public $_contentLayout = 'short';

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
    	$videos = models_VideoMapper::getLast();
    	$this->view->videos = $videos;
    }

	public function categoryAction()
    {
    	$request = $this->getRequest();

    	$id = $request->getParam('id');

    	$page =  $request->getParam('page');

    	$videos = models_VideoMapper::getAllByCategories($id);

    	$this->view->videos = $videos;

    }

    public function listcommentsAction()
    {
        $request = $this->getRequest();
        $idVideo = (int)$request->getParam('id');

        $this->view->id = $idVideo;

        $video = models_VideoMapper::findById($idVideo);
        $viewsCount = $video->viewsCount + 1;
        $this->view->viewsCount = $viewsCount;

        $video->viewsCount = $viewsCount;

        models_VideoMapper::update($video->id, $video->toArray(), models_VideoMapper::$_dbTable);

    	$comments = models_VideoCommentMapper::findByVideo($idVideo);

    	$items = array();

    	foreach ($comments as $item /* @var $item models_VideoComment */)
    	{
    		$items[] = array(
    			'name' => $item->name,
    			'text' => $item->text,
    			'time' => FW_Date::convert($item->createdTs, FW_Date::MYSQL_DATETIME, FW_Date::SITE_TIME)
    		);
    	}

    	$form = new modules_default_forms_CommentForm();

    	$captcha = $form->captcha; /* @var $captcha Zend_Form_Element_Captcha */
        $this->view->captcha = $captcha->getCaptcha()->generate();

    	$this->view->comments = $items;
    }

    public function postcommentAction()
    {
    	$request = $this->getRequest();

    	$result = false;

    	if ($request->isPost())
    	{
    		$form = new modules_default_forms_CommentForm();
    		if ($form->isValid($request->getPost()))
    		{
    		    $idVideo = $request->getParam('id');

    		    if (models_VideoMapper::findById($idVideo)) {
        			$comment = new models_VideoComment();

        			$comment->name = $form->getValue('name');
        			$comment->idVideo = $idVideo;
        			$comment->text = $form->getValue('text');

        			if (models_VideoCommentMapper::save($comment)) {
        			    $result = true;
        			}
    		    } else {
    		        $result = false;
    		    }
    		}
    	}
    	$this->view->result = true;
    }
}

