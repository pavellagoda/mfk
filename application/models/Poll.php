<?php

/**
 * Class representing Poll model
 * @author valery
 *
 */

class models_Poll {
	
	public $id;
	public $question;
	public $active;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'question'				=> $this->question,
			'active'				=> $this->active,
		);
	}
	
}