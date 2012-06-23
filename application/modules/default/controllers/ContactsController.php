<?php

class ContactsController extends modules_default_controllers_ControllerBase
{

//	public $_contentLayout = 'short';
	
    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	
		$lastTour = models_TourMapper::getLast();
		$idTour = $lastTour->id;

		$tourTable = FW_Table::getTable(1, $idTour);
		$this->view->tourTable = $tourTable;
		$poll = models_PollMapper::getActive();
   		if (null != $poll)
		{
			$pollVariants = models_PollVariantMapper::findByPollId($poll->id);
			$this->view->poll = $poll;
			$this->view->pollVariants = $pollVariants;
			
			$session = Zend_Registry::get('Zend_Session_Namespace');
			if (null == $session->votedPolls) {
			    $session->votedPolls = array();
			}
			
			$this->view->votedPolls = $session->votedPolls;
		}
		
    	$request = $this->getRequest();

		$form = new modules_default_forms_ContactForm();

		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
			    $msg = '';
				foreach ($form->getValues() as $param=>$value) {
					$msg.= $param.': '.$value.'<br/>';
				}

				FW_Mailer::sendToSite(
				    $form->getValue('name'),
				    $form->getValue('email'),
				    $msg
			    );
			    
			    $this->view->mailIsSent = true;
			    
			} else {
//				echo 'no-valid';
//				$this->view->formValues = $form->getValues();
			}
		}

		$this->view->form = $form;
		
    }
}

