<?php

namespace Core\View;

use \WebKet\Main\Main;

/**
* The core view class
*/
class View
{
	
    private $_layout = '';

	public function __construct()
	{
		
	}
    
    public function fetchPartial($template, $params = array())
    {
        extract($params);
        ob_start();
        include Main::$_object->_root_path
            . Main::$_object->_view_path
            . $template . '.php';
        return ob_get_clean();
    }
    
    public function renderPartial($template, $params = array())
    {
        echo $this->fetchPartial($template, $params);
    }
    
    public function fetch($template, $params = array())
    {
        $content = $this->fetchPartial($template, $params);
        return $this->fetchPartial(
            empty($this->_layout) ? 'layout' : $this->_layout,
            array(
            	'content' => $content,
            	'view' => $params
            )
        );
    }
    
    public function render($template, $params = array(), $layout = array())
    {
        $this->_layout = $layout;
        echo $this->fetch($template, $params);
    }
}
