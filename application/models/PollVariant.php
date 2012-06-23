<?php

/**
 * Class representing Poll Variant model
 * @author valery
 *
 */

class models_PollVariant {
	
	public $id;
	public $idPoll;
	public $text;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'poll_id'				=> $this->idPoll,
			'text'					=> $this->text,
		);
	}
	
}