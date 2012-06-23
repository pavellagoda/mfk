<?php

/**
 * Game data mapper class
 * @author valery
 *
 */

class models_GameMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_Game';

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
		
//		print_r($row); die;

		$item = new models_Game();

		if (isset($row->id))
			$item->id					= $row->id;
		if (isset($row->tour_id))
			$item->idTour				= $row->tour_id;
		if (isset($row->team_id_1))
			$item->idTeam1				= $row->team_id_1;
		if (isset($row->team_id_2))
			$item->idTeam2				= $row->team_id_2;
		if (isset($row->goals_1))
			$item->goals1				= $row->goals_1;
		if (isset($row->goals_2))
			$item->goals2				= $row->goals_2;
		if (isset($row->completed))
			$item->completed			= $row->completed;
		if (isset($row->news_id))
			$item->newsId				= $row->news_id;
		if (isset($row->sportcomplex_id))
			$item->sportcomplexId		= $row->sportcomplex_id;
		if (isset($row->place))
			$item->place				= $row->place;
	    if (isset($row->team_title_1))
			$item->teamTitle1			= $row->team_title_1;
		if (isset($row->team_title_2))
			$item->teamTitle2			= $row->team_title_2;
		if (isset($row->date))
			$item->date					= $row->date;

		return $item;
	}

	/**
	 * Get games by tour in array of objects
	 * @return array
	 */
	public static function findByTourId($idTour)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('tour_id = ?', $idTour);

		$resultSet = $db->fetchAll($select);

		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}

    public static function findAllByTournament($idTournament)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();
		$select->setIntegrityCheck(false);
		$select->from('tour', array());
		$select->joinLeft('game', 'game.tour_id = tour.id', array('*'));
		$select->joinLeft('team AS t1', 'game.team_id_1 = t1.id', array('team_title_1' => 't1.title'));
		$select->joinLeft('team AS t2', 'game.team_id_2 = t2.id', array('team_title_2' => 't2.title'));

		$select->where('tournament_id = ?', $idTournament);

		$resultSet = $db->fetchAll($select);

		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}
	
	public static function findAllByTournamentPage($idTournament,$page=1, $count=40)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();
		$select->setIntegrityCheck(false);
		$select->from('tour', array('*'));
		$select->joinLeft('game', 'game.tour_id = tour.id', array('*'));
		$select->joinLeft('team AS t1', 'game.team_id_1 = t1.id', array('team_title_1' => 't1.title'));
		$select->joinLeft('team AS t2', 'game.team_id_2 = t2.id', array('team_title_2' => 't2.title'));
//		$select->joinLeft('tour', 'tour.id = game.tour_id', array('tourName' => 'title'));
		$select->where('tournament_id = ?', $idTournament);

		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
		$paginator->setItemCountPerPage($count);
		$paginator->setCurrentPageNumber($page);

		return $paginator;
	}

	/**
	 * Find news by it's id
	 * @param int $idGame
	 * @return models_Game
	 */

	public static function findById ($idGame)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('id = ?', $idGame);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

	/**
	 * Get all games in paginator instance
	 * @param int $page
	 * @param int $idTour
	 * @param int $count
	 * @return Zend_Paginator
	 */
	public static function getAllPaginator ($page = 1, $idTour = 0, $count = 10)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select(array('*'));

		$select->setIntegrityCheck(false);

		$select->joinLeft('team as t1', 't1.id = game.team_id_1', array('teamName_1' => 'title'));

		$select->joinLeft('team as t2', 't2.id = game.team_id_2', array('teamName_2' => 'title'));
		$select->joinLeft('tour', 'tour.id = game.tour_id', array('tourName' => 'title'));

		if (0 != $idTour)
		{
			$select->where('tour_id = ?', $idTour);
		}

		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
		$paginator->setItemCountPerPage($count);
		$paginator->setCurrentPageNumber($page);

		return $paginator;
	}

	/**
	 * Save object to database
	 * @param models_Game $model
	 * @return int
	 */
	public static function save ($model)
	{
		return self::saveArray($model->toArray(), self::$_dbTable);
	}

	public static function joinArrayByTeam($idTour)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();
		$select->from('game', array('*'));
		$select->setIntegrityCheck(false);

		$select->where('tour_id = ?', $idTour);

		$select->joinLeft('team as t1', 't1.id=team_id_1', array('teamName_1' => 'title'));

		$select->joinLeft('team as t2', 't2.id=team_id_2', array('teamName_2' => 'title'));
//		echo $select;die;

		$resultSet = $db->fetchAll($select);

		return $resultSet->toArray();
	}
	
	public static function getLastMonolit()
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();
		$select->from('game', array('*'));
		$select->setIntegrityCheck(false);

		$select->joinLeft('team as t1', 't1.id=team_id_1', array('team_title_1' => 'title'));

		$select->joinLeft('team as t2', 't2.id=team_id_2', array('team_title_2' => 'title'));

		$select->where('t1.id = 4 OR t2.id=4');
		
		$select->where('completed = ?', 1);
		
		$select->order('date DESC');
		
		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}
	
	public static function getNextMonolit()
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();
		$select->from('game', array('*'));
		$select->setIntegrityCheck(false);

		$select->joinLeft('team as t1', 't1.id=team_id_1', array('team_title_1' => 'title'));

		$select->joinLeft('team as t2', 't2.id=team_id_2', array('team_title_2' => 'title'));
		
		$select->joinLeft('sportcomplexes as sc', 'sc.id=sportcomplex_id', array('place' => 'name'));

		$select->where('t1.id = 4 OR t2.id=4');
		
		$select->where('completed IS NULL OR completed = 0 ');
		
		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

}
