<?php

class models_VideoMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_Video';

	/**
	 * Init object from db row
	 * @param Zend_Db_Table_Row $row
	 */
	protected static function _initItem ($row)
	{
		$item = new models_Video();

		if (isset($row->id))
			$item->id		= $row->id;

		if (isset($row->title))
			$item->title	= $row->title;

		if (isset($row->file))
			$item->file		= $row->file;

		if (isset($row->thumb))
			$item->thumb	= $row->thumb;

		if (isset($row->video_categories_id))
			$item->idVideoCategories	= $row->video_categories_id;

		if (isset($row->comments))
			$item->comments	= $row->comments;

		if (isset($row->views_count))
			$item->viewsCount	= $row->views_count;

		return $item;
	}

	/**
	 * Find video by it's id
	 * @param int $idVideo
	 * @return models_Video
	 */

	public static function findById ($idVideo)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('id = ?', $idVideo);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
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

/**
	 * Get all videos in array of objects
	 * @return array
	 */
	public static function getAll ()
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select('*');

		$select->setIntegrityCheck(false);
		$select->joinLeft('video_comment', 'video_comment.video_id = video.id', array('comments' => 'COUNT(video_comment.id)'));
		$select->group('video.id');

		$select->order('id DESC');

		$resultSet = $db->fetchAll($select);

		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}

	public static function getLast ()
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select('*');

		$select->setIntegrityCheck(false);
		$select->joinLeft('video_comment', 'video_comment.video_id = video.id', array('comments' => 'COUNT(video_comment.id)'));
		$select->group('video.id');

		$select->order('id DESC');
		$select->limit(6);

		$resultSet = $db->fetchAll($select);

		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}

	public static function getAllByCategories ($idCategories)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select('*');

		$select->setIntegrityCheck(false);
		$select->joinLeft('video_comment', 'video_comment.video_id = video.id', array('comments' => 'COUNT(video_comment.id)'));
		$select->group('video.id');

		$select->order('id DESC');

		$select->where('video_categories_id = ?', $idCategories);
//		$select->limit(1);

		$resultSet = $db->fetchAll($select);

		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));

	}

	public static function getAllByCategoriesPage ($idCategories, $page = 1, $count = 12)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select('*');

		$select->where('video_categories_id = ?', $idCategories);
//		$select->limit(1);

		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
		$paginator->setItemCountPerPage($count);
		$paginator->setCurrentPageNumber($page);

		return $paginator;

	}

}