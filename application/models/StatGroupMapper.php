<?php

/**
 * StatGroup data mapper class
 * @author valery
 *
 */

class models_StatGroupMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_StatGroup';

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

		$item = new models_StatGroup();

		if (isset($row->id))
			$item->id					= $row->id;
		if (isset($row->parent_id))
			$item->idParent        		= $row->parent_id;
		if (isset($row->title))
			$item->title				= $row->title;
		if (isset($row->slug))
			$item->slug    				= $row->slug;

		return $item;
	}

	/**
	 * Find StatGroup by it's id
	 * @param int $idStatGroup
	 * @return models_StatGroup
	 */

	public static function findById ($idStatGroup)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('id = ?', $idStatGroup);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

    public static function findBySlug ($slug)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('slug = ?', $slug);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

    public static function getAll () {
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$result = $db->fetchAll($select);

		return self::_createArrayFromResultSet($result, array(__CLASS__, '_initItem'));
	}

	/**
	 * Get all StatGroup in paginator instance
	 * @param int $idParent
	 * @param int $page
	 * @param int $count
	 * @return Zend_Paginator
	 */
	public static function getAllPaginator ($idParent = -1, $page = 1, $count = 10)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		if (-1 != $idStatGroupCategory)
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
	 * @param models_StatGroup $model
	 * @return int
	 */
	public static function save ($model)
	{
		return self::saveArray($model->toArray(), self::$_dbTable);
	}

}