<?php

/**
 * Class representing BlogPost model
 * @author valery
 *
 */

class models_BlogPost {
	
	public $id;
	public $idUser;
	public $title;
	public $content;
	public $createdTs;
	public $updatedTs;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'user_id'				=> $this->idUser,
			'title'					=> $this->title,
			'content'				=> $this->content,
			'created_ts'			=> $this->createdTs,
			'updated_ts'			=> $this->updatedTs,
		);
	}
	
}