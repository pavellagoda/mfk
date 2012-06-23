<?php

/**
 * Class representing VideoComment model
 * @author valery
 *
 */

class models_VideoComment {

	public $id;
	public $idVideo;
	public $name;
	public $text;
	public $createdTs;

	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'video_id'				=> $this->idVideo,
			'name'					=> $this->name,
			'text'					=> $this->text,
			'created_ts'			=> $this->createdTs,
		);
	}

}