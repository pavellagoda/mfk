<?php

/**
 * Team data mapper class
 * @author valery
 *
 */

class models_RulesMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_Rules';

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
		
		$item = new models_Rules();
		
		if (isset($row->id))
			$item->id					= $row->id;
		if (isset($row->name))
			$item->name					= $row->name;
		if (isset($row->link))
			$item->link					= $row->link;
		if (isset($row->content))
			$item->content				= $row->content;
		
		return $item;
	}

	/**
	 * Find news by it's id
	 * @param int $idTeam
	 * @return models_Team
	 */
	
	public static function findById ($idTeam)
	{
		$db = self::_getDbTable(self::$_dbTable);
		
		$select = $db->select();
		
		$select->where('id = ?', $idTeam);
		
		$result = $db->fetchRow($select);
		
		return self::_initItem($result);
	}
	
	
	public static function findByLink ($link)
	{
		$db = self::_getDbTable(self::$_dbTable);
		
		$select = $db->select();
		
		$select->where('link = ?', $link);
		
		$result = $db->fetchRow($select);
		
		return self::_initItem($result);
	}
	
	/**
	 * Get all teams in paginator instance
	 * @param int $page
	 * @param int $count
	 * @return Zend_Paginator
	 */
	public static function getAllPaginator ($page = 1, $count = 10)
	{
		$db = self::_getDbTable(self::$_dbTable);
		
		$select = $db->select();
		
		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
		$paginator->setItemCountPerPage($count);
		$paginator->setCurrentPageNumber($page);
		
		return $paginator;
	}
	
	/**
	 * Get all teams in array of objects
	 * @return array
	 */
	public static function getAll ()
	{
		$db = self::_getDbTable(self::$_dbTable);
		
		$select = $db->select();
		$select->order('id ASC');

		$resultSet = $db->fetchAll($select);
		
		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}
	
	/**
	 * Save object to database 
	 * @param models_Team $model
	 * @return int
	 */
	public static function save ($model)
	{
		return self::saveArray($model->toArray(), self::$_dbTable);
	}
	
} 