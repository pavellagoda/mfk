<?php

/**
 * Class representing News Category model
 * @author valery
 *
 */

class models_NewsCategory {
	
	public $id;
	public $title;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'title'					=> $this->title,
		);
	}
	
}