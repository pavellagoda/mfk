<?php

/**
 * Class representing News model
 * @author valery
 *
 */

class models_News {
	
	public $id;
	public $idNewsCategory;
	public $title;
	public $short;
	public $full;
	public $createdTs;
	public $customIcon;
	public $viewsCount;
	public $type;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'news_category_id'		=> $this->idNewsCategory,
			'title'					=> $this->title,
			'short'					=> $this->short,
			'full'					=> $this->full,
			'created_ts'			=> $this->createdTs,
			'custom_icon'			=> $this->customIcon,
			'views_count'			=> $this->viewsCount,
			'type'					=> $this->type
		);
	}
	
}