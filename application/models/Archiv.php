<?php

/**
 * Class representing Chat model
 * @author valery
 *
 */

class models_Archiv {
	
	public $id;
	public $title;
	public $content;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'title'					=> $this->title,
			'content'				=> $this->content,
		);
	}
	
}