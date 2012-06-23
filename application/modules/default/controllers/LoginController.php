<?php

/**
 * Login page controller
 *
 * @author Pasha
 *
 */

class LoginController extends modules_default_controllers_ControllerBase
{
	protected $_bForLoggedUsersOnly = false;

	public function init ()
	{
		parent::init();
	}

	public function indexAction ()
	{
		if ( FW_User::isLogged() )
		{
			$this->_redirect('/');
		}
		
		$request = $this->getRequest();
		
		if ($request->isPost())
		{
			$form = new modules_default_forms_LoginForm();
			
			if ($form->isValid($request->getPost()))
			{
				if (FW_User::doLogin($form, $request->getPost(), false))
				{
					$this->_helper->redirector(null, null);
				}
			}
			$badLoginText = 'Логин и пароли не совпадают!';
			$this->view->badLoginText = $badLoginText;
		}
	}

} // end of class
