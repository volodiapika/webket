<?php

namespace Request\UsersUpdateRequest;

/**
* The users update request
*/
class UsersUpdateRequest
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
        	'id' => '"required":"1"',
        	'role' => '"required":"1"',
        	'login' => '"required":"1","min":"3"',
            'firstname' => '"required":"1","min":"3"',
            'lastname' => '"required":"1","min":"3"',
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
