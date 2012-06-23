<?php

/**
 * Class representing Chat model
 * @author valery
 *
 */

class models_Forwards {
	
	public $id;
	public $name;
	public $team;
	public $goals;
	public $pen;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'name'					=> $this->name,
			'team'					=> $this->team,
			'goals'					=> $this->goals,
			'pen'					=> $this->pen,
		);
	}
	
}