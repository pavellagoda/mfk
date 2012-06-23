<?php

/**
 * Tour data mapper class
 * @author valery
 *
 */

class models_PhotoMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_Photo';

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

		$item = new models_Photo();

		if (isset($row->id))
			$item->id					= $row->id;
		if (isset($row->title))
			$item->title				= $row->title;
		if (isset($row->photo_categories_id))
			$item->idPhotoCategories	= $row->photo_categories_id;
		
		if (isset($row->category_title))
			$item->categoryTitle		= $row->category_title;

		return $item;
	}

	/**
	 * Find tour by it's id
	 * @param int $idTour
	 * @return models_Tour
	 */

	public static function findById ($idPhoto)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('id = ?', $idPhoto);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

	public static function getAllByCategories ($idCategories)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select('*');

		$select->where('photo_categories_id = ?', $idCategories);
//		$select->limit(1);

		$result = $db->fetchAll($select);

		return self::_createArrayFromResultSet($result, array(__CLASS__, '_initItem'));
	}
	
	public static function getAllByCategoriesPage ($idCategories, $page = 1, $count = 12)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select('*');

		$select->where('photo_categories_id = ?', $idCategories);
//		$select->limit(1);

		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
		$paginator->setItemCountPerPage($count);
		$paginator->setCurrentPageNumber($page);

		return $paginator;
	
	}

	public static function getLast ($num)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select('*');

		$select->setIntegrityCheck(false);
		
		$select->order('id DESC');

		$select->limit($num);

		$resultSet = $db->fetchAll($select);

		return self::_createArrayFromResultSet($resultSet,array(__CLASS__, '_initItem'));
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

		$resultSet = $db->fetchAll($select);

		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}
	
	public static function getAllWithCategoryPage ($page=1, $count=20)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();
		
		$select->setIntegrityCheck(false);
		
		$select->from('photo');
		
		$select->joinLeft('photo_categories as pc', 'pc.id = photo.photo_categories_id', array('category_title'=>'pc.title'));

		$select->order('pc.id DESC');
		
		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
		$paginator->setItemCountPerPage($count);
		$paginator->setCurrentPageNumber($page);
		
		return $paginator;
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
