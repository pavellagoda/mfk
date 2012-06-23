<?php

/**
 * PollVariant data mapper class
 * @author valery
 *
 */

class models_PollVariantMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_PollVariant';

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

		$item = new models_PollVariant();

		if (isset($row->id))
			$item->id					= $row->id;
		if (isset($row->poll_id))
			$item->idPoll				= $row->poll_id;
		if (isset($row->text))
			$item->text					= $row->text;
		if (isset($row->votes))
			$item->votes				= $row->votes;

		return $item;
	}

	/**
	 * Get poll variants by poll in array of objects
	 * @return array
	 */
	public static function findByPollId($idPoll)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->from('poll_variant', array('*', 'votes' =>
			'(SELECT COUNT(1) FROM poll_answer WHERE poll_answer.poll_variant_id = poll_variant.id)'
		));

		$select->where('poll_id = ?', $idPoll);

		$resultSet = $db->fetchAll($select);

		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}

	/**
	 * Find news by it's id
	 * @param int $idPollVariant
	 * @return models_PollVariant
	 */

	public static function findById ($idPollVariant)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('id = ?', $idPollVariant);

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

    public static function getAllWithStats ()
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->setIntegrityCheck(false);

		$select->from('poll_variant', array('*', 'votes' =>
			'(SELECT COUNT(1) FROM poll_answer WHERE poll_answer.poll_variant_id = poll_variant.id)'
		));

		$select->order('votes DESC');

		$resultSet = $db->fetchAll($select);

		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}

	/**
	 * Get all poll variants in paginator instance
	 * @param int $page
	 * @param int $idPoll
	 * @param int $count
	 * @return Zend_Paginator
	 */
	public static function getAllPaginator ($page = 1, $idPoll = 0, $count = 10)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		if (0 != $idPoll)
		{
			$select->where('poll_id = ?', $idPoll);
		}

		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
		$paginator->setItemCountPerPage($count);
		$paginator->setCurrentPageNumber($page);

		return $paginator;
	}

	/**
	 * Save object to database
	 * @param models_PollVariant $model
	 * @return int
	 */
	public static function save ($model)
	{
		return self::saveArray($model->toArray(), self::$_dbTable);
	}

}