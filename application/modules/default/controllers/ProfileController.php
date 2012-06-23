<?php

class ProfileController extends modules_default_controllers_ControllerBase
{

	protected $_bForLoggedUsersOnly = true;
	
    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction()
    {
    	

    }
    
	public function editDataAction()
    {
    	
    	$form = new modules_default_forms_EditProfileDataForm();
    	
    	$user = FW_User::getLoggedUser();
    	
    	$request = $this->getRequest();
    	
    	if($request->isPost())
    	{
    		if($form->isValid($request->getPost()))
    		{
    			$user->name 		= $form->getValue('name');
    			$user->secondName 	= $form->getValue('second_name');
    			
    			models_UsersMapper::update($user->id,$user->toArray(), models_UsersMapper::$_dbTable);
    		
    			$this->_redirect('/profile');
    		}
    	}
    	
    	$form->populate(
    		array(
				'name'			=>$user->name,
    			'second_name'	=>$user->secondName,
    			'email'			=>$user->email,
    		)
    	);
    	
    	$this->view->form = $form;
    }
    
	public function editPasswordAction()
    {
    	
    	$form = new modules_default_forms_EditPasswordForm();
    	
    	$user = FW_User::getLoggedUser();
    	
    	$request = $this->getRequest();
    	
    	if($request->isPost())
    	{
    		if($form->isValid($request->getPost()))
    		{
    			$user->password 		= $form->getValue('password');
    			
    			models_UsersMapper::update($user->id,$user->toArray(), models_UsersMapper::$_dbTable);
    		
    			$this->_redirect('/profile');
    		}
    	}
    	
    	$this->view->form = $form;
    }
    
	public function editPhotoAction()
    {
    	
    	$form = new modules_default_forms_EditPhotoForm();
    	
    	$user = FW_User::getLoggedUser();
    	
    	$request = $this->getRequest();
    	
    	if($request->isPost())
    	{
    		if($form->isValid($request->getPost()))
    		{
    			if($user->photo&&file_exists($_SERVER['DOCUMENT_ROOT'] .'/i/users/'.$user->photo))
    				unlink($_SERVER['DOCUMENT_ROOT'] .'/i/users/'.$user->photo);
				
    			$tmp_name = $_FILES["photo"]["tmp_name"];
				$imgtype = explode(".", $_FILES['photo']['name']);
				$imgext = $imgtype[count($imgtype) - 1];
				$path = $_SERVER['DOCUMENT_ROOT'] .'/i/users/'.$user->id.'.'.$imgext;
				move_uploaded_file($tmp_name, $path);
					
				$user->photo = $user->id.'.'.$imgext;
					
				models_UsersMapper::update($user->id,$user->toArray(), models_UsersMapper::$_dbTable);
					
    			$this->_redirect('/profile');
    		}
    	}
    	
    	$this->view->form = $form;
    }
    
	public function deletePhotoAction()
    {
    	
    	$user = FW_User::getLoggedUser();
    	
    	if($user->photo&&file_exists($_SERVER['DOCUMENT_ROOT'] .'/i/users/'.$user->photo))
    		unlink($_SERVER['DOCUMENT_ROOT'] .'/i/users/'.$user->photo);
				
		$user->photo = null;
					
		models_UsersMapper::update($user->id,$user->toArray(), models_UsersMapper::$_dbTable);
					
    	$this->_redirect('/profile');
    	
    }
}

