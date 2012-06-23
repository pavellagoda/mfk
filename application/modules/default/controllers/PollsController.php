<?php

class PollsController extends modules_default_controllers_ControllerBase {

//	public $_contentLayout = 'short';

	protected $_bForLoggedUsersOnly = true;

    public function init() {
        /* Initialize action controller here */
    	parent::init();
    }

    public function indexAction() {
        $request = $this->getRequest();

        $votedPolls = models_PollAnswerMapper::getVotedPolls(FW_User::getLoggedUserId());

        if ($request->isPost()) {
            $idPollVariant = (int)$request->getParam('answer', 0);
            $answer = new models_PollAnswer();

            $variant = models_PollVariantMapper::findById($idPollVariant);

            if (null == $variant) {
                throw new Zend_Controller_Action_Exception('Page not found', 404);
            }

            if (!array_key_exists($variant->idPoll, $votedPolls)) {
                $answer->idPollVariant = $idPollVariant;
                $answer->idUser = FW_User::getLoggedUserId();
                if (models_PollAnswerMapper::save($answer)) {
                    $votedPolls[$variant->idPoll] = 1;
                }
            }
        }

        $this->view->votedPolls = $votedPolls;

    	$lastTour = models_TourMapper::getLast();
        $idTour = $lastTour->id;

        $polls = models_PollMapper::getAll();
        $this->view->polls = $polls;

        $pollsVariants = models_PollVariantMapper::getAllWithStats();
        $this->view->pollsVariants = $pollsVariants;

        $tourTable = FW_Table::getTable(1, $idTour);
        $this->view->tourTable = $tourTable;

    }
}

