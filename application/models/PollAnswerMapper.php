<?php

/**
 * PollAnswer data mapper class
 * @author valery
 *
 */

class models_PollAnswerMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_PollAnswer';

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

		$item = new models_PollAnswer();

		if (isset($row->id))
			$item->id			= $row->id;
		if (isset($row->poll_variant_id))
			$item->idPollVariant		= $row->poll_variant_id;
                if (isset($row->user_id))
			$item->idUser   		= $row->user_id;
		if (isset($row->created_ts))
			$item->createdTs		= $row->created_ts;

		return $item;
	}

	/**
	 * Find news by it's id
	 * @param int $idPollAnswer
	 * @return models_PollAnswer
	 */

	public static function findById ($idPollAnswer) {
            $db = self::_getDbTable(self::$_dbTable);

            $select = $db->select();

            $select->where('id = ?', $idPollAnswer);

            $result = $db->fetchRow($select);

            return self::_initItem($result);
	}

	public static function getAll () {
            $db = self::_getDbTable(self::$_dbTable);

            $select = $db->select();

            $resultSet = $db->fetchAll($select);

            return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}

        public static function getVotedPolls ($idUser = 0) {
            $db = self::_getDbTable(self::$_dbTable);

            $select = $db->select();
            $select->setIntegrityCheck(false);

            $select->from('poll_answer', array());
            $select->joinLeft('poll_variant', 'poll_variant.id = poll_answer.poll_variant_id', array('GROUP_CONCAT(poll_variant.poll_id) AS c'));

            $select->where('user_id = ?', (int)$idUser);

            $resultSet = $db->fetchRow($select);

            return array_fill_keys(explode(',', $resultSet['c']), 1);
	}

	/**
	 * Get all poll Answers in paginator instance
	 * @param int $page
	 * @param int $idPoll
	 * @param int $count
	 * @return Zend_Paginator
	 */
	public static function getAllPaginator ($page = 1, $idPoll = 0, $count = 10) {
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
	 * @param models_PollAnswer $model
	 * @return int
	 */
	public static function save ($model)
	{
		return self::saveArray($model->toArray(), self::$_dbTable);
	}

}