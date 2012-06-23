<?php

class FeedController extends modules_default_controllers_ControllerBase
{

    public function init()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
//        $cache = Model_Cache::getCore();
//        $cacheItem = 'rssNewsFeed';

//        if (!$feedContent = $cache->load($cacheItem)) {
            $feedContent = FW_Feed::renderFeed('rss');
//            $cache->save($feedContent, $cacheItem);
//        }

        $feed = Zend_Feed::importString($feedContent);
        $feed->send();
    }

    public function fetchAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        FW_Feed::fetchFeed();
        
    }

    public function atomAction()
    {
//        $cache = Model_Cache::getCore();
//        $cacheItem = 'atomNewsFeed';

//        if (!$feedContent = $cache->load($cacheItem)) {
            $feedContent = FW_Feed::renderFeed('atom');
//            $cache->save($feedContent, $cacheItem);
//        }

        $feed = Zend_Feed::importString($feedContent);
        $feed->send();
    }

}
