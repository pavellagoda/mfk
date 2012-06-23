<?php

/**
 * Class representing News table
 * @author valery
 *
 */

class models_DbTable_News extends Zend_Db_Table_Abstract
{
	
	public $_name = 'news';
	
	public $_primary = 'id';
}