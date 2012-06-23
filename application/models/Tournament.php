<?php

/**
 * Class representing Comment model
 * @author valery
 *
 */

class models_Tournament {
	
	public $id;
	public $title;
	public $type;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'title'					=> $this->title,
			'type'					=> $this->type,
		);
	}
	
}