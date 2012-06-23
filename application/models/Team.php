<?php

/**
 * Class representing Team model
 * @author valery
 *
 */

class models_Team {
	
	public $id;
	public $title;
	public $club_id;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'title'					=> $this->title,
			'club_id'				=> $this->club_id,
		);
	}
	
}