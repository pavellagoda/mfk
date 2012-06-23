<?php

/**
 * StatYear data mapper class
 * @author valery
 *
 */

class models_StatYearMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_StatYear';

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

		$item = new models_StatYear();

		if (isset($row->id))
			$item->id					= $row->id;
		if (isset($row->stat_group_id))
			$item->idStatGroup     		= $row->stat_group_id;
		if (isset($row->title))
			$item->title				= $row->title;
		if (isset($row->year))
			$item->year    				= $row->year;
		if (isset($row->content))
		    $item->content    			= $row->content;

		return $item;
	}

	/**
	 * Find StatYear by it's id
	 * @param int $idStatYear
	 * @return models_StatYear
	 */

	public static function findById ($idStatYear)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('id = ?', $idStatYear);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

	public static function findByYearAndGroup ($year, $group)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('year = ?', $year);
		$select->where('stat_group_id = ?', $group);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

    public static function getAll () {
		$db = self::_getDbTable(self::$_dbTable);
		
		$select = $db->select();
		
		$select->order('title');

		$result = $db->fetchAll($select);

		return self::_createArrayFromResultSet($result, array(__CLASS__, '_initItem'));
	}

	/**
	 * Get all StatYear in paginator instance
	 * @param int $idParent
	 * @param int $page
	 * @param int $count
	 * @return Zend_Paginator
	 */
	public static function getAllPaginator ($idParent = -1, $page = 1, $count = 10)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		if (-1 != $idStatYearCategory)
		{
			$select->where('parent_id = ?', $idParent);
		}

		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
		$paginator->setItemCountPerPage($count);
		$paginator->setCurrentPageNumber($page);

		return $paginator;
	}

	/**
	 * Save object to database
	 * @param models_StatYear $model
	 * @return int
	 */
	public static function save ($model)
	{
		return self::saveArray($model->toArray(), self::$_dbTable);
	}

}