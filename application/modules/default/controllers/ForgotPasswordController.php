<?php

class ForgotPasswordController extends modules_default_controllers_ControllerBase
{

    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	
    	$form = new modules_default_forms_ForgotPasswordForm();
    	
    	$request = $this->getRequest();
    	
    	if($request->isPost())
    	{
    		if($form->isValid($request->getPost()))
    		{
    			$user = models_UsersMapper::findByEmail($form->getValue('email'));
    			if(null==$user)
    			{
    				$this->view->wasPost = true;
    			}
    			else
    			{
	    			$body = 'Ваш пароль: '.$user->password;
	    			FW_Mailer::send($body, $form->getValue('email'), $user->name, 'admin@mfk-monoit.com', 'МФК Монолит', 'Васстановление пароля'); 
    				$this->view->sended = true;
    			}
    		
    		}
    	}
    	
    	$this->view->form = $form;

    }
}

