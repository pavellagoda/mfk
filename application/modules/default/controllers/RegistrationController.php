<?php

/**
 * Registration page controller
 *
 * @author den
 *
 */
class RegistrationController extends modules_default_controllers_ControllerBase {

    protected $_bForLoggedUsersOnly = false;
//----------------------------------------------------------------------------------------------------
	public $ajaxable = array('validate-step2' => array('json'));

//----------------------------------------------------------------------------------------------------


    public function init()
    {

    	parent::init();
    	
    }

//----------------------------------------------------------------------------------------------------

	/**
	 * Candidate registration action
	 */
    public function indexAction()
    {
        $oRequest = $this->getRequest();

        if (Lemar_User::isLogged())
        {
            $this->_redirect('/');
        }

        if ($oRequest->isPost())
        {
        	$candidateForm = new modules_default_forms_CandidateRegistrationForm();
        	$userForm = new modules_default_forms_RegistrationForm();
        	
        	if ($oRequest->getParam('country_id') == 1)
        	{
        		$userForm->getElement('state')->setRequired(true);
        	}
        	
        	$validCandidate = $candidateForm->isValid($oRequest->getParams());
        	$validUser = $userForm->isValid($oRequest->getParams());
	
            if ($validUser && $validCandidate)
            {        	
            	if ( Lemar_User::doRegister($userForm, 
            		$candidateForm, $oRequest->getPost(), models_Users::CANDIDATE) )
            	{
					$this->_forward('succesful');
				}
            }
            else
            {
            	$this->view->userFormValues = $userForm->getValues();
                $this->view->userFormErrorCodes = $userForm->getErrors();
                $this->view->userFormErrorMessages = $userForm->getMessages();
                
                $this->view->candidateFormValues = $candidateForm->getValues();
                $this->view->candidateFormErrorCodes = $candidateForm->getErrors();
                $this->view->candidateFormErrorMessages = $candidateForm->getMessages();
            }
        }
        $this->view->headLink()->appendStylesheet('/css/datapicker.css');
		
//		$this->view->headScript()->appendFile('/js/lib/jquery-1.4.2.min.js');
		$this->view->headScript()->appendFile('/js/lib/jquery-ui-1.8.4.custom.min.js');
		$this->view->headScript()->appendFile('/js/date.js');

        $this->view->states = models_StatesMapper::getAll();
	   	$this->view->countries = models_CountriesMapper::getAll();
    }
//------------------------------------------------------------------------------
    public function hrAction()
    {
    	
    	$this->view->headTitle('HR Registration', 'PREPEND');
    	$this->view->headScript()->appendFile('/js/lib/jquery.maskedinput-1.2.2.min.js');
    	$this->view->headScript()->appendFile('/js/zipValidate.js');
    	
    	$request = $this->getRequest();
    	
        if (Lemar_User::isLogged())
        {

            $this->_redirect('/');
        }

    	if($request->isPost())
    	{
    		$hrForm = new modules_default_forms_RegistrationForm();
    		
    		if ($request->getParam('country_id') == 1)
        	{
        		$hrForm->getElement('state')->setRequired(true);
        	}
    		
			if($hrForm->isValid( $request->getPost() ))
			{
				$f = new Zend_Form();
				
  				if( Lemar_User::doRegister($hrForm, $f, $request->getPost(), 
  					models_Users::HR) )
  				{
					$this->_forward('succesful');
  				}
			}

			
	        $this->view->userFormValues = $hrForm->getValues();
	        $this->view->userFormErrorCodes = $hrForm->getErrors();
	        $this->view->userFormErrorMessages = $hrForm->getMessages();			
			
    	}
              
    	$this->view->states = models_StatesMapper::getAll();
	   	$this->view->countries = models_CountriesMapper::getAll();
	   	
    }
//------------------------------------------------------------------------------
	public function hr2Action()
	{
		$idUSA = 1;
		$request = $this->getRequest();
		if( $request->isPost() )
		{
			$idUser = Lemar_User::getLoggedUserId();			
			$formValues = $request->getPost();
			
			$aCategories = models_CategoriesMapper::getPrintableAsArray();
			$aIndustry = models_IndustriesMapper::getPrintableAsArray();
			$aCountries = models_CountriesMapper::getPrintableAsArray();
			$aStates = models_StatesMapper::getPrintableAsArray();
			
			
			$formValid = true;
			//	validate categories;
			$aSelectedCategories = explode(',',$formValues['h-categories']);
		
			foreach ( $aSelectedCategories as $category )
			{
				if(!isset($aCategories[$category]))
					$formValid = false;
			}
			//	validate industry
			if( is_null(models_IndustriesMapper::findById($formValues['industry'])))
				$formValid = 3;
			//	validate cities
			$aUniqueCountries = array();
			foreach ($formValues['countries'] as $item)
			{
				foreach ( $item as $key => $value )
				{
					
					if($key == $idUSA)
					{
						$ex = explode('|',$value);
						$state = $ex[0];
						
						if( !isset($aStates[$state]) )
						{
							$formValid = false;
						}
					}	
					else
					{
						if(!isset( $aCountries[$key]) )
							$formValid = false;
					}
				}
				if(!in_array( $key , $aUniqueCountries  ) )
					$aUniqueCountries[] = $key;
			}
			if($formValid)
			{
				//	matches job info
				$aJobInfo = explode(',',$formValues['job_info']);
				foreach($aJobInfo as $jobInfo)
				{
					$oMachedJobInfo = new models_UserMatchedJobInfo();
					$oMachedJobInfo->setIdUser( $idUser );
					$oMachedJobInfo->setJobInfo( trim($jobInfo) );
					
					models_UserMatchedJobInfoMapper::save($oMachedJobInfo);		
				}
				//	matched categories
				foreach ( $aSelectedCategories as $category )
				{
					$oMachedCategory = new models_UserMatchedCategories();
					$oMachedCategory->setIdUser( $idUser );
					$oMachedCategory->setIdCategory( $category ); 
					models_UserMatchedCategoriesMapper::save( $oMachedCategory );
				}
				//	matched industry
				$oMatchedIndustry = new models_UserMatchedIndustry();
				$oMatchedIndustry->setIdUser($idUser);
				$oMatchedIndustry->setIdIndustry( $formValues['industry'] );
				models_UserMatchedIndustryMapper::save($oMatchedIndustry);
				//	matched countries
				foreach ( $aUniqueCountries as $country )
				{
					$oMatchedCountry = new models_UserMatchedCountries();
					$oMatchedCountry->setIdCountry($country);
					$oMatchedCountry->setIdUser($idUser);
					models_UserMatchedCountriesMapper::save($oMatchedCountry);					
				}
				//	matched states
				foreach ($formValues['countries'] as $item)
				{
					foreach ( $item as $key => $value )
					{
						if($key == $idUSA)
						{
							$ex = explode('|',$value);
							
							$oMatchedState = new models_UserMatchedStates();
							$oMatchedState->setIdUser($idUser);
							$oMatchedState->setIdCountry($idUSA);
							$oMatchedState->setState($ex[0]);

							models_UserMatchedStatesMapper::save($oMatchedState);
						}
					}
				}
				//	matched salary
				
				$oMatchedSalary = new models_UserMatchedSalary();
				$oMatchedSalary->setIdUser( $idUser );
				$oMatchedSalary->setSalaryMin( $formValues['min_salary'] );
				$oMatchedSalary->setSalaryMax( $formValues['max_salary'] );
				models_UserMatchedSalaryMapper::save( $oMatchedSalary );

				//	matched cities
				
				foreach ($formValues['countries'] as $item)
				{
					foreach ( $item as $key => $value )
					{
						if($key == $idUSA)
						{
							$ex = explode('|',$value);
							$oUserMatchedState = models_UserMatchedStatesMapper::findByUserAndState($idUser,$ex[0]);
							if( $oUserMatchedState && $ex[1] != 'null' )
							{
								$oMatchedCity = new models_UserMatchedCities();
								$oMatchedCity->setIdCountry( $key );
								$oMatchedCity->setIdState( $oUserMatchedState->getId() );
								$oMatchedCity->setIdUser( $idUser );
								$oMatchedCity->setName( $ex[1] );
								models_UserMatchedCitiesMapper::save();
							}
						}
						else
						{
							$ex = explode('|',$value);
							if( $ex[1] != 'null' )
							{
								$oMatchedCity = new models_UserMatchedCities();
								$oMatchedCity->setIdCountry( $key );
								$oMatchedCity->setIdState( NULL );
								$oMatchedCity->setIdUser( $idUser );
								$oMatchedCity->setName( $ex[1] );
								models_UserMatchedCitiesMapper::save($oMatchedCity);
							}
						}
					}
				}
					
				
			}			
			$this->_redirect('/registration/step2');

		}
		
		
		$this->view->headScript()->appendFile('/js/hr-registration.js');
		$this->view->headScript()->appendFile('/js/lib/jquery.metadata.js');
		
		$this->view->countries = models_CountriesMapper::getAll();
		$this->view->states = models_StatesMapper::getAll();
		$this->view->industries = models_IndustriesMapper::getAll();
		$this->view->categories = models_CategoriesMapper::findByParentId(0);
	}
//------------------------------------------------------------------------------  
	public function recruiterAction()
    {
    	$this->view->headScript()->appendFile('/js/lib/jquery.maskedinput-1.2.2.min.js');
    	$this->view->headScript()->appendFile('/js/zipValidate.js');
    	$this->view->headTitle('Recruiter Registration', 'PREPEND');
    	
        $oRequest = $this->getRequest();

        if (Lemar_User::isLogged())
        {
            $this->_redirect('/');
        }

        if ($oRequest->isPost())
        {
        	$recruiterForm = new modules_default_forms_RecruiterRegistrationForm();
        	$userForm = new modules_default_forms_RegistrationForm();
        	
        	$userForm->getElement('company')->setRequired(true)
        		->setAllowEmpty(false);
        	
        	if ($oRequest->getParam('country_id') == 1)
        	{
        		$userForm->getElement('state')->setRequired(true);
        	}
        	
        	$validUser = $userForm->isValid($oRequest->getParams());
        	$validRecruiter = $recruiterForm->isValid($oRequest->getParams());

            if ($validUser && $validRecruiter)
            {
                if ( Lemar_User::doRegister($userForm, $recruiterForm, 
                	$oRequest->getPost(), models_Users::RECRUITER) )
                {
					$this->_forward('succesful');
				}
            }
            else
            {
            	$this->view->userFormValues = $userForm->getValues();
                $this->view->userFormErrorCodes = $userForm->getErrors();
                $this->view->userFormErrorMessages = $userForm->getMessages();
                
                $this->view->recruiterFormValues = $recruiterForm->getValues();
                $this->view->recruiterFormErrorCodes = $recruiterForm->getErrors();
                $this->view->recruiterFormErrorMessages = $recruiterForm->getMessages();
            }
        }
        
        $this->view->countries = models_CountriesMapper::getAll();
        $this->view->states = models_StatesMapper::getAll();
    }
	public function validateStep2Action()
	{
		$idUSA = 1;
		$request = $this->getRequest();
		$sJSONcountries = $request->getParam('countries',null);
		
		$aCountries = models_CountriesMapper::getPrintableAsArray();
		$aStates = models_StatesMapper::getPrintableAsArray();
	
		if( $sJSONcountries )
		{
			$countries = json_decode($sJSONcountries);
			
			foreach ( $countries as $item )
			{
				if(!isset($aCountries[$item->country]))
				{
					$this->view->error = 'country not exist';
					$this->view->success = 0;
					return false;
				}
				if( $item->country == $idUSA && !isset($aStates[$item->state]))
				{
					$this->view->error = 'state not selected';
					$this->view->success = 0;
					return false;
				}
				
				if( $item->country == $idUSA && is_null( $item->state ) )
				{
					$this->view->error = 'state not selected';
					$this->view->success = 0;
					return false;
				}
			}
		}
		else
		{
			$this->view->error = 'bad json string';
			$this->view->success = 0;
			return false;
		}
		
		
		$this->view->success = 1;

	}

//------------------------------------------------------------------------------

    public function activateAction()
    {    	
		$user = models_UsersMapper::findById( $this->_request->getParam('id') );
    	
    	if ($user &&
    		$user->getStatus() == models_Users::STATUS_PENDING && 
    		$this->_request->getParam('key') == $user->getHash())
    	{
    		
    		if ( Lemar_User::activate($user->getId()) )
    		{
    			Lemar_User::setLogged($user->getId());
				
				if (!$user->getUserMatchFilled())
				{
					$this->_redirect('/profile/matched-criterias/');
				}
				
				return;
    		}
    	}
    	
    	$this->_helper->redirector(null, 'index');
    }
    
//------------------------------------------------------------------------------

    public function succesfulAction()
    {    	
		
    }
    
}

//  CLASS