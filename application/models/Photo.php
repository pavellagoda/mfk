<?php

/**
 * Class representing Tour model
 * @author valery
 *
 */

class models_Photo {

	public $id;
	public $title;
	public $idPhotoCategories;

	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'title'					=> $this->title,
			'photo_categories_id'	=> $this->idPhotoCategories,
		);
	}

}
