<?php

/**
 * Tour data mapper class
 * @author valery
 *
 */

class models_PhotoCategoriesMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_PhotoCategories';

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

		$item = new models_PhotoCategories();

		if (isset($row->id))
			$item->id					= $row->id;
		if (isset($row->title))
			$item->title				= $row->title;
		return $item;
	}

	/**
	 * Find tour by it's id
	 * @param int $idTour
	 * @return models_Tour
	 */

	public static function findById ($idCategories)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('id = ?', $idCategories);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}


	/**
	 * Get all tours in paginator instance
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
	 * Get all tours in array of objects
	 * @return array
	 */
	public static function getAll ()
	{
		$db = self::_getDbTable(self::$_dbTable);
		
		$select = $db->select();
		
		$select->order('id DESC');
		
		$resultSet = $db->fetchAll($select);
		
		return self::_createArrayFromResultSet($resultSet,array(__CLASS__, '_initItem'));
	}

	/**
	 * Save object to database
	 * @param models_Tour $model
	 * @return int
	 */
	public static function save ($model)
	{
		return self::saveArray($model->toArray(), self::$_dbTable);
	}

}
