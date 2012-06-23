<?php

/**
 * Class representing Poll Answer model
 * @author valery
 *
 */

class models_PollAnswer {

	public $id;
	public $idPollVariant;
        public $idUser;
	public $createdTs;

	public function toArray() {
            return array(
                'id'				=> $this->id,
                'poll_variant_id'		=> $this->idPollVariant,
                'user_id'                       => $this->idUser,
                'created_ts'			=> $this->createdTs,
            );
	}

}