<?php

/**
 * VideoComment data mapper class
 * @author valery
 *
 */

class models_VideoCommentMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_VideoComment';

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

		$item = new models_VideoComment();

		if (isset($row->id))
			$item->id					= $row->id;
		if (isset($row->video_id))
			$item->idVideo				= $row->video_id;
		if (isset($row->name))
			$item->name				= $row->name;
		if (isset($row->text))
			$item->text				= $row->text;
		if (isset($row->created_ts))
			$item->createdTs			= $row->created_ts;

		return $item;
	}

	/**
	 * Find comments by it's id
	 * @param int $idComment
	 * @return models_VideoComment
	 */

	public static function findById ($idComment)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('id = ?', $idComment);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

	public static function findByVideo ($idVideo, $count = 5)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('video_id = ?', $idVideo);
		$select->limit($count);
		$select->order('created_ts DESC');

		$resultSet = $db->fetchAll($select);

		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}

	/**
	 * Get all comments in paginator instance
	 * @param int $idVideo
	 * @param int $page
	 * @param int $count
	 * @return Zend_Paginator
	 */
	public static function getAllPaginator ($idVideo = 0, $page = 1, $count = 10)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		if (0 != $idVideo)
		{
			$select->where('video_id = ?', $idVideo);
		}

		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
		$paginator->setItemCountPerPage($count);
		$paginator->setCurrentPageNumber($page);

		return $paginator;
	}

	/**
	 * Save object to database
	 * @param models_Video $model
	 * @return int
	 */
	public static function save ($model)
	{
		return self::saveArray($model->toArray(), self::$_dbTable);
	}

}