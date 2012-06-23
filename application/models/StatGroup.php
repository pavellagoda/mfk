<?php

/**
 * Class representing News model
 * @author valery
 *
 */

class models_StatGroup {

	public $id;
	public $idParent;
	public $title;
	public $slug;

	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'parent_id'				=> $this->idParent,
			'title'					=> $this->title,
			'slug'					=> $this->slug,
		);
	}

}