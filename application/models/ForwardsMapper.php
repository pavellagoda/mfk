<?php

/**
 * Chat data mapper class
 * @author valery
 *
 */

class models_ForwardsMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_Forwards';

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
		
		$item = new models_Forwards();
		
		if (isset($row->id))
			$item->id					= $row->id;
		if (isset($row->name))
			$item->name					= $row->name;
		if (isset($row->team))
			$item->team					= $row->team;
		if (isset($row->goals))
			$item->goals				= $row->goals;
		if (isset($row->pen))
			$item->pen					= $row->pen;
		
		return $item;
	}

	/**
	 * Find news by it's id
	 * @param int $idChat
	 * @return models_Chat
	 */
	
	public static function findById ($idClub)
	{
		$db = self::_getDbTable(self::$_dbTable);
		
		$select = $db->select();
		
		$select->where('id = ?', $idClub);
		
		$result = $db->fetchRow($select);
		
		return self::_initItem($result);
	}
	
	
	/**
	 * Get all chats in paginator instance
	 * @param int $idNews
	 * @param int $page
	 * @param int $count
	 * @return Zend_Paginator
	 */
	public static function getAllPaginator ($idNews = 0, $page = 1, $count = 10)
	{
		$db = self::_getDbTable(self::$_dbTable);
		
		$select = $db->select();
		
		if (0 != $idNews)
		{
			$select->where('news_id = ?', $idNews);
		}

		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
		$paginator->setItemCountPerPage($count);
		$paginator->setCurrentPageNumber($page);
		
		return $paginator;
	}
	
	
	public static function getAll ($count=null)
	{
		$db = self::_getDbTable(self::$_dbTable);
		
		$select = $db->select();
		
		$select->order('goals DESC');
		$select->order('pen');
		
		if($count)
			$select->limit($count);

		$resultSet = $db->fetchAll($select);
		
		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
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