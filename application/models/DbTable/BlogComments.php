<?php

/**
 * Class representing Comment table
 * @author valery
 *
 */

class models_DbTable_BlogComments extends Zend_Db_Table_Abstract
{
	
	public $_name = 'blog_comments';
	
	public $_primary = 'id';
}