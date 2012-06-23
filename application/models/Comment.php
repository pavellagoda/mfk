<?php

/**
 * Class representing Comment model
 * @author valery
 *
 */

class models_Comment {
	
	public $id;
	public $idNews;
        public $idUser;
	public $name;
	public $text;
	public $createdTs;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
                        'user_id'                               => $this->idUser,
			'news_id'				=> $this->idNews,
			'name'					=> $this->name,
			'text'					=> $this->text,
			'created_ts'			=> $this->createdTs,
		);
	}
	
}