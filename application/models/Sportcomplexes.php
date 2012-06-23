<?php

/**
 * Class representing News Category model
 * @author valery
 *
 */

class models_Sportcomplexes {
	
	public $id;
	public $name;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'name'					=> $this->name,
		);
	}
	
}