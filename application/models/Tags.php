<?php

/**
 * Class representing News Category model
 * @author valery
 *
 */

class models_Tags {
	
	public $id;
	public $name;
	public $link;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'name'					=> $this->name,
			'link'					=> $this->link,
		);
	}
	
}