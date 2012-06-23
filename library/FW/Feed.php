<?php
/**
 * @author valery
 *
 *
 */
class FW_Feed
{
    protected static $rssAddress = 'http://sport.ua/rss/futsal';

    public static function fetchFeed($rssAddr = null) {

        $rss = self::$rssAddress;
        if (isset($rssAddr)) {
            $rss = $rssAddr;
        }

        $channel = Zend_Feed::import($rss);

        foreach ($channel as $item) {
            /* @var $item Zend_Feed_Entry_Rss */
            $title = FW_Strings::filterWhitespaces($item->title());
            $pubDate = FW_Strings::filterWhitespaces($item->pubDate());
            $description = FW_Strings::filterWhitespaces($item->description());
            $link = FW_Strings::filterWhitespaces($item->link());
            $author = FW_Strings::filterWhitespaces($item->author());

            $hash = md5($title . '*.*.*' . $description);

            if (models_ForeignNewsMapper::findByHash($hash)) {
                continue;
            }

            $feedItem = new models_ForeignNews();
            $feedItem->title = $title;
            $feedItem->createdTs = FW_Date::convert(strtotime($pubDate), Zend_Date::TIMESTAMP, FW_Date::MYSQL_DATETIME) ;
            $feedItem->full = null;
            $feedItem->hash = $hash;
            $feedItem->short = $description;
            $feedItem->url = $link;
            $feedItem->author = $author;

            models_ForeignNewsMapper::save($feedItem);
        }

    }

    public static function renderFeed($type = 'rss') {
        $feed = new Zend_Feed_Writer_Feed();

        $feed->setTitle('ФК Монолит Харьков');
        $feed->setDescription('Новости ФК Монолит Харьков');
        $feed->setLink('http://mfk-monolit.com/');

        $feed->setDateModified(time());
        $feed->addHub('http://pubsubhubbub.appspot.com/');

        $news = models_NewsMapper::getLast(10);

        foreach ($news as $item) {
            $entry = $feed->createEntry();
            $entry->setTitle($item->title);
            $entry->setDateCreated(FW_Date::convert($item->createdTs, FW_Date::MYSQL_DATETIME, Zend_Date::TIMESTAMP));
            $entry->setDateModified(FW_Date::convert($item->createdTs, FW_Date::MYSQL_DATETIME, Zend_Date::TIMESTAMP));
            $entry->setDescription($item->short);
            $entry->setContent($item->full);
            $entry->setLink(
            	'http://mfk-monolit.com/index/view/id/' . $item->id
            );

            $feed->addEntry($entry);
        }

        switch ($type) {
            case 'atom':
                $feed->setFeedLink('http://mfk-monolit.com/feed/atom', 'atom');
                return $feed->export('atom');
                break;
            default:
                $feed->setFeedLink('http://medkharkov.org.ua/feed/', 'rss');
                return $feed->export('rss');
                break;
        }
    }

}
?>