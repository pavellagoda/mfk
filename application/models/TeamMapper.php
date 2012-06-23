<?php

/**
 * Team data mapper class
 * @author valery
 *
 */

class models_TeamMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_Team';

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
		
		$item = new models_Team();
		
		if (isset($row->id))
			$item->id					= $row->id;
		if (isset($row->title))
			$item->title				= $row->title;
		if (isset($row->club_id))
			$item->club_id				= $row->club_id;
		
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
		
		$select->order('title');

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
	
	public static function getResultsAtCurrentTour($idTour)
	{
		$db = self::_getDbTable(self::$_dbTable);
		
		$select = 'SELECT
		 	(SELECT COUNT(1) FROM game WHERE ((goals_1 > goals_2 AND team_id_1 = t1.id) OR (goals_1 < goals_2 AND team_id_2 = t1.id)) AND tour_id <= '.$idTour.') AS `win`,
		 	(SELECT COUNT(1) FROM game WHERE (goals_1 = goals_2 AND (team_id_1 = t1.id OR team_id_2 = t1.id)) AND tour_id <= '.$idTour.') AS `draw`,
		 	(SELECT COUNT(1) FROM game WHERE ((goals_1 < goals_2 AND team_id_1 = t1.id) OR (goals_1 > goals_2 AND team_id_2 = t1.id)) AND tour_id <= '.$idTour.') AS `fail`,
		 	(IFNULL((SELECT SUM(goals_1) FROM game WHERE team_id_1 = t1.id) + (SELECT SUM(goals_2) FROM game WHERE team_id_2 = t1.id),0)) AS `goals`,
		 	(IFNULL((SELECT SUM(goals_2) FROM game WHERE team_id_1 = t1.id) + (SELECT SUM(goals_1) FROM game WHERE team_id_2 = t1.id),0)) AS `goals_fail`,
		t1.title, t1.id FROM `team` AS t1
		 LEFT JOIN `game` AS g ON g.team_id_1 = t1.id OR g.team_id_2 = t1.id
		 WHERE 1 = completed AND tour_id <= '.$idTour.'
		 GROUP BY t1.id
		 ORDER BY `win`*3 + `draw` DESC, `win`+`draw`+`fail` ASC;';

		$resultSet = $db->getAdapter()->fetchAll($select, array());

		return  $resultSet;
	}

} 