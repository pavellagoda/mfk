<?php

/**
 * Comment data mapper class
 * @author valery
 *
 */

class models_BlogCommentsMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_BlogComments';

	/**
	 * Init object from db row
	 * @param Zend_Db_Table_Row $row
	 */
	protected static function _initItem ($row)
	{
		if (null == $row)
		{
			return null;
		}
		
		$item = new models_BlogComments();
		
		if (isset($row->id))
			$item->id					= $row->id;
		if (isset($row->user_id))
			$item->idUser				= $row->user_id;
		if (isset($row->blog_post_id))
			$item->idBlogPost			= $row->blog_post_id;
		if (isset($row->content))
			$item->content				= $row->content;
		if (isset($row->created_ts))
			$item->createdTs			= $row->created_ts;
		
		return $item;
	}

	/**
	 * Find news by it's id
	 * @param int $idComment
	 * @return models_Comment
	 */
	
	public static function findById ($idComment)
	{
		$db = self::_getDbTable(self::$_dbTable);
		
		$select = $db->select();
		
		$select->where('id = ?', $idComment);
		
		$result = $db->fetchRow($select);
		
		return self::_initItem($result);
	}
	
	public static function findByNews ($idNews, $count = 5)
	{
		$db = self::_getDbTable(self::$_dbTable);
		
		$select = $db->select();
		
		$select->where('news_id = ?', $idNews);
		$select->limit($count);
		$select->order('created_ts DESC');
		
		$resultSet = $db->fetchAll($select);
		
		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}
	
	/**
	 * Get all comments in paginator instance
	 * @param int $idNews
	 * @param int $page
	 * @param int $count
	 * @return Zend_Paginator
	 */
	public static function getAllPaginator ($idNews = 0, $page = 1, $count = 10)
	{
		$db = self::_getDbTable(self::$_dbTable);
//		SELECT id, text, news_id, created_ts, user_id, IF(comment.user_id IS NOT NULL, CONCAT_WS(' ', users.name, users.second_name), comment.name) FROM comment LEFT JOIN users ON users.id = comment.user_id WHERE news_id = 218;
		$select = $db->select();
		$select->setIntegrityCheck(false);

		$select->from('comment', array('id', 'text', 'news_id', 'created_ts', 'user_id', 'IF(comment.user_id IS NOT NULL, CONCAT_WS(" ", users.name, users.second_name), comment.name) AS name'));
		$select->joinLeft('users', 'users.id = comment.user_id', array());
		
		if (0 != $idNews)
		{
			$select->where('news_id = ?', $idNews);
		}


		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
		$paginator->setItemCountPerPage($count);
		$paginator->setCurrentPageNumber($page);
		
		return $paginator;
	}
	
	/**
	 * Save object to database 
	 * @param models_News $model
	 * @return int
	 */
	public static function save ($model)
	{
		return self::saveArray($model->toArray(), self::$_dbTable);
	}

} 