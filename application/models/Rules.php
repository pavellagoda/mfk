<?php

/**
 * Class representing Chat model
 * @author valery
 *
 */

class models_Rules {
	
	public $id;
	public $name;
	public $link;
	public $content;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'name'					=> $this->name,
			'link'					=> $this->link,
			'content'				=> $this->content,
		);
	}
	
}