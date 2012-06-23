<?php

/**
 * Class representing News Categories table
 * @author valery
 *
 */

class models_DbTable_NewsCategory extends Zend_Db_Table_Abstract
{
	
	public $_name = 'news_category';
	
	public $_primary = 'id';
}