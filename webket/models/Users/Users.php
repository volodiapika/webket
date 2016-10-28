<?php

namespace Models\Users;

use \Core\Orm\Orm;

/**
* The users
*/
class Users extends Orm
{
	
	public function login()
	{
		return nl2br($this->login);
	}

	public function firstname()
	{
		return nl2br($this->firstname);
	}
    
	public function lastname()
	{
	    return nl2br($this->lastname);
	}

	public function password()
	{
	    return nl2br($this->password);
	}
}
