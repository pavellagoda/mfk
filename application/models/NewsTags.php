<?php

/**
 * Class representing News Category model
 * @author valery
 *
 */

class models_NewsTags {
	
	public $idNews;
	public $idTag;
	
	public function toArray()
	{
		return array(
			'news_id'				=> $this->idNews,
			'tag_id'				=> $this->idTag,
		);
	}
	
}