<?php

namespace Controllers\HomeController;

use \Core\View\View;
use \WebKet\Main\Main;

/**
* The home contoller
*/
class HomeController extends View
{
	
	public function __construct()
	{
		
	}

	public function index()
	{
		$posts = array(
            'title' => 'Web Ket | Home',
            'auth' => Main::auth()
		);
        $this->render(
       		'body',
       		array('posts' => $posts)
       	);
	}
}
