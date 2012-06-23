<?php

/**
 * Poll data mapper class
 * @author valery
 *
 */

class models_PollMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_Poll';

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

		$item = new models_Poll();

		if (isset($row->id))
			$item->id					= $row->id;
		if (isset($row->question))
			$item->question				= $row->question;
		if (isset($row->active))
			$item->active				= $row->active;

		return $item;
	}

	/**
	 * Find news by it's id
	 * @param int $idPoll
	 * @return models_Poll
	 */
	public static function findById ($idPoll)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('id = ?', $idPoll);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

	/**
	 * Get active poll
	 * @return models_Poll
	 */
	public static function getActive ()
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('active = 1');
		$select->order('RAND()');

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

	/**
	 * Get all polls in paginator instance
	 * @param int $page
	 * @param int $idTour
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
	 * @param models_Poll $model
	 * @return int
	 */
	public static function save ($model)
	{
		return self::saveArray($model->toArray(), self::$_dbTable);
	}

}