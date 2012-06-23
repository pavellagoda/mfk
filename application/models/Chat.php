<?php

/**
 * Class representing Chat model
 * @author valery
 *
 */

class models_Chat {
	
	public $id;
	public $name;
	public $text;
	public $createdTs;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'name'					=> $this->name,
			'text'					=> $this->text,
			'created_ts'			=> $this->createdTs,
		);
	}
	
}