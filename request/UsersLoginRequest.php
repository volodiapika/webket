<?php

namespace Request\UsersLoginRequest;

/**
* The users login request
*/
class UsersLoginRequest
{
	
	public function __construct()
	{
		
	}

	public function index()
	{
		return array('id');
	}

	public function rules()
	{
        return array(
        	'login' => '"required":"1","min":"3"',
            'password' => '"required":"1","min":"3"',
        );
	}
    
	public function action()
	{
		return 'POST';
	}
    
	public function authorize()
	{
	    return true;
	}
}
