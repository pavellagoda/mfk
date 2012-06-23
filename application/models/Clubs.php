<?php

/**
 * Class representing Chat model
 * @author valery
 *
 */

class models_Clubs {
	
	public $id;
	public $name;
	public $city;
	public $logo;
	public $description;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'name'					=> $this->name,
			'logo'					=> $this->logo,
			'city'					=> $this->city,
		);
	}
	
}