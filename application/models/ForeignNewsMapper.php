<?php

/**
 * News data mapper class
 * @author valery
 *
 */

class models_ForeignNewsMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_ForeignNews';

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

		$item = new models_ForeignNews();

		if (isset($row->id))
			$item->id		= $row->id;
		if (isset($row->hash))
			$item->hash		= $row->hash;
		if (isset($row->title))
			$item->title		= $row->title;
		if (isset($row->short))
			$item->short		= $row->short;
		if (isset($row->full))
			$item->full		= $row->full;
		if (isset($row->created_ts))
			$item->createdTs	= $row->created_ts;
		if (isset($row->url))
			$item->url              = $row->url;

		return $item;
	}

	/**
	 * Find news by it's id
	 * @param int $idNews
	 * @return models_ForeignNews
	 */

	public static function findById ($idNews)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('id = ?', $idNews);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

	public static function findByHash ($hash)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('hash = ?', $hash);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

	public static function getAll ()
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$resultSet = $db->fetchAll($select);

		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}

	public static function getLast ($num)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select('*');
		
		$select->setIntegrityCheck(false);

		$select->order('created_ts DESC');

		$select->order('id DESC');

		$select->limit($num);

		$resultSet = $db->fetchAll($select);

		return self::_createArrayFromResultSet($resultSet,array(__CLASS__, '_initItem'));
	}


	/**
	 * Get all news in paginator instance
	 * @param int $page
	 * @param int $count
	 * @return Zend_Paginator
	 */
	public static function getAllPaginator ($page = 1, $count = 25)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->order('created_ts DESC');

		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
		$paginator->setItemCountPerPage($count);
		$paginator->setCurrentPageNumber($page);

		return $paginator;
	}


	/**
	 * Save object to database
	 * @param models_ForeignNews $model
	 * @return int
	 */
	public static function save ($model)
	{
		return self::saveArray($model->toArray(), self::$_dbTable);
	}

}
