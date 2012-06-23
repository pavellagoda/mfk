<?php

/**
 * Class representing Tour model
 * @author valery
 *
 */

class models_PhotoCategories {

	public $id;
	public $title;

	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'title'					=> $this->title,
		);
	}

}
