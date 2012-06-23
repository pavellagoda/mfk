<?php

/**
 * Class representing StatYear model
 * @author valery
 *
 */

class models_StatYear {

	public $id;
	public $idStatGroup;
	public $title;
	public $year;
	public $content;

	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'stat_group_id'		    => $this->idStatGroup,
			'title'					=> $this->title,
			'year'					=> $this->year,
		    'content'				=> $this->content,
		);
	}

}