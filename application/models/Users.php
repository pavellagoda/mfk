<?php

/**
 * Class representing Comments model
 * @author Pasha
 *
 */

class models_Users {
	
	public $id;
	public $email;
	public $password;
	public $name;
	public $secondName;
	public $photo;
	
	public function toArray()
	{
		return array(
			'id'				=> $this->id,
			'email'				=> $this->email,
			'password'			=> $this->password,
			'name'				=> $this->name,
			'second_name'		=> $this->secondName,
			'photo'				=> $this->photo,
		);
	}
	
}