<?php

namespace Request\MessagesRequest;

/**
* The messages request
*/
class MessagesRequest
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
            'title' => '"required":"1","min":"3","max":"1000","regex":"([a-z0-9-_]+)"',
            'message' => '"required":"1","min":"3"',
            'idto' => '"required":"1"',
            'idfrom' => '"required":"1"',
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
