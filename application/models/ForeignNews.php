<?php

/**
 * Class representing ForeignNews model
 * @author valery
 *
 */

class models_ForeignNews {
	
	public $id;
	public $hash;
	public $title;
	public $short;
	public $full;
        public $url;
        public $author;
	public $createdTs;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'hash'                  		=> $this->hash,
			'title'					=> $this->title,
			'short'					=> $this->short,
			'full'					=> $this->full,
                        'author'                                => $this->author,
			'created_ts'                    	=> $this->createdTs,
			'url'                                   => $this->url,
		);
	}
	
}