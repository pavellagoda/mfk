<?php

/**
 * DateTime library
 * @author valery
 *
 */

class FW_Date
{

	const MYSQL_DATE = 'yyyy-MM-dd';
	const MYSQL_DATETIME = 'yyyy-MM-dd HH:mm:ss';
	const SITE_DATE = 'dd.MM.yyyy';
	const SITE_TIME = 'HH:mm:ss';

	public static function convert($date, $fromFormat, $toFormat)
	{
		$zd = new Zend_Date($date, $fromFormat);
		return $zd->get($toFormat);
	}

}