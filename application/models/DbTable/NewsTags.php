<?php

/**
 * Class representing User table
 * @author tc
 *
 */

class models_DbTable_NewsTags extends Zend_Db_Table_Abstract
{
	
	public $_name = 'news_tags';
	
	public $_primary = array('news_id', 'tag_id');
}