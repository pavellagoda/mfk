<?php

/**
 * Class representing Game model
 * @author valery
 *
 */

class models_Game {
	
	public $id;
	public $idTour;
	public $goals1;
	public $goals2;
	public $idTeam1;
	public $idTeam2;
	public $completed;
	public $newsId;
	public $sportcomplexId;
	public $date;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'tour_id'				=> $this->idTour,
			'goals_1'				=> $this->goals1,
			'goals_2'				=> $this->goals2,
			'team_id_1'				=> $this->idTeam1,
			'team_id_2'				=> $this->idTeam2,
			'news_id'				=> $this->newsId,
			'completed'				=> $this->completed,
			'sportcomplex_id'		=> $this->sportcomplexId,
			'date'					=> $this->date,
		);
	}
	
}