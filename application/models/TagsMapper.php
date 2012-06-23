<?php

/**
 * News category data mapper class
 * @author valery
 *
 */

class models_TagsMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_Tags';

	/**Category
	 * Init object from db row
	 * @param Zend_Db_Table_Row $row
	 */
	protected static function _initItem ($row)
	{
		if (null == $row)
		{
			return null;
		}
		
		$item = new models_Tags();
		
		if (isset($row->id))
			$item->id					= $row->id;
		if (isset($row->name))
			$item->name				= $row->name;
		if (isset($row->link))
			$item->link				= $row->link;
		
		return $item;
	}

	/**
	 * Find news category by it's id
	 * @param int $idNewsCategory
	 * @return models_NewsCategory
	 */
	
	public static function findById ($idNewsCategory)
	{
		$db = self::_getDbTable(self::$_dbTable);
		
		$select = $db->select();
		
		$select->where('id = ?', $idNewsCategory);
		
		$result = $db->fetchRow($select);
		
		return self::_initItem($result);
	}
	
	/**
	 * Find tag by it's connection in news_tags
	 * @param int $idNewsCategory
	 * @return models_NewsCategory
	 */
	
	public static function findByNewsId ($idNews)
	{
		$db = self::_getDbTable(models_NewsTagsMapper::$_dbTable);
		
		$select = $db->select();
		$select->setIntegrityCheck(false);
		$select->from('news_tags',array());
		$select->joinLeft('tags', 'news_tags.tag_id = tags.id', array('*'));
		$select->where('news_tags.news_id = ?', $idNews);
		
		$resultSet = $db->fetchAll($select);
		
		return self::_createArrayFromResultSet($resultSet,array(__CLASS__, '_initItem'));
	}
	
	/**
	 * Get all news categories
	 * @return array
	 */
	public static function getAll ()
	{
		$db = self::_getDbTable(self::$_dbTable);
		
		$select = $db->select();
		
		$resultSet = $db->fetchAll($select);
		
		return self::_createArrayFromResultSet($resultSet,array(__CLASS__, '_initItem'));
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
	 * Save object to database 
	 * @param models_NewsCategory $model
	 * @return int
	 */
	public static function save ($model)
	{
		return self::saveArray($model->toArray(), self::$_dbTable);
	}

} 