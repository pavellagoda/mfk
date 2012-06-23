<?php

class models_UsersMapper extends models_MapperBase
{
	public static $_dbTable = 'models_DbTable_Users';

//----------------------------------------------------------------------------------------------------

	public static function _initItem($oRow)
	{
		if (null === $oRow)
		{
			return null;
		}

		$oItem = new models_Users();

		if (isset($oRow->id))
			$oItem->id					= $oRow->id;
		if (isset($oRow->email))
			$oItem->email				= $oRow->email;
		if (isset($oRow->password))
			$oItem->password			= $oRow->password;
		if (isset($oRow->name))
			$oItem->name				= $oRow->name;
		if (isset($oRow->second_name))
			$oItem->secondName			= $oRow->second_name;
		if (isset($oRow->photo))
			$oItem->photo				= $oRow->photo;

		return $oItem;
	}

//----------------------------------------------------------------------------------------------------


//----------------------------------------------------------------------------------------------------

	public static function getAll()
	{
		$db = self::_getDbTable(self::$_dbTable);
		$select  = $db->select();

		$select->from($db, array('*'));
		$select->setIntegrityCheck(false);

		$ret = $db->fetchAll($select);

		return $ret;
	}
//----------------------------------------------------------------------------------------------------


	/**
	 * Finds provider by it's id
	 * @param int $id
	 * @return models_Providers
	 */
	public static function findById($id)
	{
		$DbTable = self::_getDbTable(self::$_dbTable);
		$select = $DbTable->select();
		$select->setIntegrityCheck(false);

		$select->from($DbTable, array('*'));
	  	$select->where('id = ?', $id);

	  	$result = $DbTable->fetchRow($select);

	  	return self::_initItem($result);
	}
	
	public static function findByEmail($email)
	{
		$DbTable = self::_getDbTable(self::$_dbTable);
		$select = $DbTable->select();
		$select->setIntegrityCheck(false);

		$select->from($DbTable, array('*'));
	  	$select->where('email = ?', $email);

	  	$result = $DbTable->fetchRow($select);

	  	return self::_initItem($result);
	}


//----------------------------------------------------------------------------------------------------

	public static function save ($model)
	{
		return self::saveArray($model->toArray(), self::$_dbTable);
	}

//----------------------------------------------------------------------------------------------------

	public static function edit($id, $data)
	{
		$DbTable = self::_getDbTable(self::$_dbTable);
		$Update = $DbTable->update($data,  'id = ' . $id);

		return $Update;
	}

//----------------------------------------------------------------------------------------------------

	public static function updateAll($data)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$update = $db->update($data, '1=1');

		return $update;
	}

//----------------------------------------------------------------------------------------------------

}
