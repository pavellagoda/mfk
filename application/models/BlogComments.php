<?php

/**
 * Class representing BlogComments model
 * @author valery
 *
 */

class models_BlogComments {
	
	public $id;
	public $idUser;
	public $idBlogPost;
	public $content;
	public $createdTs;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'user_id'				=> $this->idUser,
			'blog_post_id'			=> $this->idBlogPost,
			'content'				=> $this->content,
			'created_ts'			=> $this->createdTs,
		);
	}
	
}