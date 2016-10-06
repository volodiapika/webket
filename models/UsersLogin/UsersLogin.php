<?php

namespace Models\UsersLogin;

use \Core\Orm\Orm;

/**
* The users login
*/
class UsersLogin extends Orm
{
	
	public function login()
	{
		return nl2br($this->login);
	}
    
	public function password()
	{
	    return nl2br($this->password);
	}
}
