<?php

/**
 * Class representing Game model
 * @author valery
 *
 */

class models_Video {

	public $id;
	public $title;
	public $file;
	public $thumb;
	public $idVideoCategories;
	public $viewsCount;

	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'title'					=> $this->title,
			'file'					=> $this->file,
			'thumb'					=> $this->thumb,
			'video_categories_id'	=> $this->idVideoCategories,
			'views_count'			=> $this->viewsCount,
		);
	}

}
