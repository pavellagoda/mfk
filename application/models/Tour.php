<?php

/**
 * Class representing Tour model
 * @author valery
 *
 */

class models_Tour {

	public $id;
	public $title;
	public $idTournament;

	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'title'					=> $this->title,
			'tournament_id'			=> $this->idTournament,
		);
	}

}
