<?php

/**
 * Tour data mapper class
 * @author valery
 *
 */

class models_TourMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_Tour';

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

		$item = new models_Tour();

		if (isset($row->id))
			$item->id					= $row->id;
		if (isset($row->title))
			$item->title				= $row->title;
		if (isset($row->tournament_id))
			$item->idTournament			= $row->tournament_id;
		if (isset($row->tournament_title))
			$item->tournamentTitle			= $row->tournament_title;

		return $item;
	}

	/**
	 * Find tour by it's id
	 * @param int $idTour
	 * @return models_Tour
	 */

	public static function findById ($idTour)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('id = ?', $idTour);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

	public static function getAllByTournament ($idTournament,$isDesc = true)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select('*');

		$select->where('tournament_id = ?', $idTournament);
		if($isDesc)
			$select->order('id DESC');
//		$select->limit(1);

		$result = $db->fetchAll($select);

		return self::_createArrayFromResultSet($result, array(__CLASS__, '_initItem'));
	}

    public static function getLastAll ($idTournament = null)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		if (null != $idTournament) {
		    $select->where('tournament_id = ?', $idTournament);
		}

		$select->order('id DESC');
		$select->limit(1);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

    public static function getLast ($idTournament=1)
	{

		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select(array('*'));
		$select->setIntegrityCheck(false);

		$select->joinInner('game', 'game.tour_id = tour.id AND game.completed = 1', array());

	    $select->where('tournament_id = ?', $idTournament);
	    $select->group('tour.id');

	    $select->order('id DESC');
		$select->limit(1);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

    public static function getFirstPending ($idTournament=1)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select(array('*'));
		$select->setIntegrityCheck(false);

                $select->where('tournament_id = ?', $idTournament);
                $select->where('(SELECT COUNT(1) FROM game WHERE game.tour_id = tour.id AND IFNULL(game.completed,0) = 1) = 0');

                $select->order('id ASC');
		$select->limit(1);

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
		$select->setIntegrityCheck(false);
		$select->from('tour', array('*'));
		$select->order('tournament_id DESC');
		$select->order('id DESC');
		$select->joinLeft('tournament', 'tournament_id = tournament.id', array('tournament_title'=>'tournament.title'));

		$resultSet = $db->fetchAll($select);

		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
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
