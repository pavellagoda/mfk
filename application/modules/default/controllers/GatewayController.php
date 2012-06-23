<?php

class GatewayController extends modules_default_controllers_ControllerBase
{
    public function init() {
        if (! $this->getRequest()->isXmlHttpRequest()) {
            parent::init();
            $this->view->title = 'Home';
        }
    }

    public function amfAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        $server = new Zend_Amf_Server();

        $server->setClass('FW_Gateway_Amf');
        $response = $server->handle();
        echo $response;
    }

}