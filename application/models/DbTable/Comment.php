<?php

/**
 * Class representing Comment table
 * @author valery
 *
 */

class models_DbTable_Comment extends Zend_Db_Table_Abstract
{
	
	public $_name = 'comment';
	
	public $_primary = 'id';
}