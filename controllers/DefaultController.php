<?php

namespace Controllers\DefaultController;

use \Core\View\View;
use \WebKet\Main\Main;

/**
* The default controller
*/
class DefaultController extends View
{
	
	public function __construct($parameters = array())
	{
		if (!empty($parameters)) {
            $posts = array(
			    'title' => 'Web Ket | error 404',
			    'error' => $parameters,
			    'auth' => Main::auth()
			);
			$this->render(
	       		'errorf',
	       		array('posts' => $posts)
	       	);
		}
		else {
			$posts = array(
			    'title' => 'Web Ket | error 404',
			    'auth' => Main::auth()
			);
			$this->render(
	       		'error404',
	       		array('posts' => $posts)
	       	);
	    }
	}
}
