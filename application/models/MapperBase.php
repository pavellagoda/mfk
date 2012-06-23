<?php
/**
 * Base Mapper class
 * @author tc
 *
 */
class models_MapperBase
{
	/**
	 * Set DbTable object
	 *
	 * @param $sDbTable
	 * @return Zend_Db_Table
	 */
	protected static function _setDbTable($sDbTable)
	{
		if (is_string($sDbTable))
		{
			$oDbTable = new $sDbTable();
		}
		if (! $oDbTable instanceof Zend_Db_Table_Abstract)
		{
			throw new Exception('Invalid table data gateway provided');
		}
		return $oDbTable;
	}

	/**
	 * Get DbTable object
	 *
	 * @param $sDbTable
	 * @return Zend_Db_Table
	 */
	protected static function _getDbTable($sDbTable)
	{
				return !empty($sDbTable) ? self::_setDbTable($sDbTable) : null;
	}

	/**
	 * Creates array from result set object and calls callback function to init model object
	 *
	 * @param Zend_Db_Table_Rowset_Abstract $oResultSet
	 * @param array $aCallbackFunction
	 * @return array
	 */
	protected static function _createArrayFromResultSet(Zend_Db_Table_Rowset_Abstract $oResultSet, array $aCallbackFunction)
	{
		$aResultArray = array();
		foreach ($oResultSet as $oRow)
		{
			$aResultArray[] = call_user_func($aCallbackFunction, $oRow);
		}
		return $aResultArray;
	}

	/**
	 * Creates array from result set object and calls callback function to init model object
	 *
	 * @param STD OBject $oResultSet
	 * @param array $aCallbackFunction
	 * @return array
	 */
	protected static function _createArrayFromResultSetSTD($oResultSet, array $aCallbackFunction)
	{
		$aResultArray = array();
		foreach ($oResultSet as $oRow)
		{
			$aResultArray[] = call_user_func($aCallbackFunction, $oRow);
		}
		return $aResultArray;
	}
	
	protected static function _initDb($mode = Zend_Db::FETCH_ASSOC)
	{
		$sEnv = APPLICATION_ENV;
		$oCon = Zend_Registry::getInstance()->get('config')->$sEnv;

		$Config = $oCon->resources->db;
		$db = Zend_Db::factory($Config);
		$db->setFetchMode($mode);

		return $db;
	}
	
//----------------------------------------------------------------------------------------------------
		
	public static function saveArray($data, $_dbTable)
	{
		$db = self::_getDbTable($_dbTable);
		$result  = $db->insert($data);
		return $result;
	}
				
//----------------------------------------------------------------------------------------------------

	public static function update($id, $data, $_dbTable)
	{
		$db = self::_getDbTable($_dbTable);

		$where['id = ?'] =  (int) $id;
		$update = $db->update($data, $where);
						
		return $update;
	}
				
//----------------------------------------------------------------------------------------------------
	public static function findByIdBase($id, $_dbTable)
	{
		$db = self::_getDbTable($_dbTable);
		$select  = $db->select();

		$select->from($db, array('*'));
		$select->where('id = ?', $id);

		$result = $db->fetchRow($select);

		return $result;
	}
		
//----------------------------------------------------------------------------------------------------

	public static function deleteFromBase($id, $_dbTable)
	{
		$DbTable = self::_getDbTable($_dbTable);
		
		$Delete  = $DbTable->delete('id = ' . $id);
		
		return $Delete;		 
	}
				
}
