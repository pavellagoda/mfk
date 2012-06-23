<?php

/**
 * Class representing Comment table
 * @author valery
 *
 */

class models_DbTable_BlogPost extends Zend_Db_Table_Abstract
{
	
	public $_name = 'blog_post';
	
	public $_primary = 'id';
}