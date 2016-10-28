<?php

namespace WebKet\Main;

/**
* The main container
*/
class Main
{
    
    public $_root_path = '';
    private $_models_path = 'models/';
    private $_models_name = 'Models';
    private $_request_path = 'request/';
    private $_request_name = 'Request';
    private $_controllers_path = 'controllers/';
    private $_controllers_name = 'Controllers';
    private $_controller_default = 'DefaultController';
    private $_routes_path = 'routes.php';
    private $_config_path = 'configs.php';
    private $_map_core_class = 'Maps/MapCoreClass';
    public $_core_path = 'core/';
    public $_view_path = 'views/';
    public $_ormmodel_path = 'Orm/Ormmodel.php';
    public static $_object;
    private $_patterns = array();
    private $_models = array();
    public $_map_config = array();
    public $_map_language = array();
    public $_status_request = false;

	public function __construct()
	{
        set_exception_handler(function($exception) {
            if (Main::$_object->_status_request)
                die (
                    json_encode(
                        array(
                            'error' => array(
                                $exception->getMessage()
                            )
                        )
                    )
                );
            else
                Main::error($exception->getMessage());
        });
        set_error_handler(function($code, $message, $file, $line) {
            $pos = strpos($message, 'Undefined index:');
            if ($pos !== false)
                Main::error($message);
            throw new ErrorException($message, 0, $code, $file, $line);
        });
        
        session_start();
        
        self::$_object = $this;
		$this->_root_path = dirname(__FILE__) . '/../';
        $this->configLoad();
        $this->languageLoad();
		spl_autoload_register(
            array('WebKet\Main\Main', 'autoloadClass')
        );
		$this->controllerLoad();
	}
    
    public static function autoloadClass($class_name)
    {       
        $classNameBegin = $class_name;
        $beginSize = strlen($classNameBegin);
        $classNameBegin = str_replace(
            self::$_object->_models_name . '\\',
            '',
            $classNameBegin
        );
        $endSize = strlen($classNameBegin);
        if ($beginSize != $endSize) {
            $classNameBegin = str_replace("\\", "/", $classNameBegin);
            include self::$_object->_root_path
                . self::$_object->_models_path
                . $classNameBegin
                . '.php';
            return;
        }
        
        include self::$_object->_root_path
            . self::$_object->_core_path
            . self::$_object->_map_core_class
            . '.php';
        foreach ($mapCoreClass as $key => $value) {
            if ($key == $class_name)
                include self::$_object->_root_path
                    . self::$_object->_core_path . $value;
        }
    }
    
	private function controllerLoad()
	{
		include $this->_root_path . $this->_routes_path;
	}
    
    private function configLoad()
    {
        include $this->_root_path . $this->_config_path;
        $this->_map_config = $mapConfig;
    }
    
    private function languageLoad()
    {
        include $this->_root_path
            . $this->_map_config['languagePath']
            . $this->_map_config['languageName'];
        $getDefined = get_defined_vars();
        $getDefined = $getDefined[
            $this->_map_config['languageValue']
        ];
        $this->_map_language = $getDefined;
    }
    
    static public function model($name, $path)
    {
        self::$_object->_models[] = array(
            $name => $path
        );
    }
    
    static public function pattern($name, $code)
    {
        self::$_object->_patterns[] = array(
            $name => $code
        );
    }
    
    public function startModels($url)
    {
        if (empty($this->_models))
            return array();
        $beginLength = strlen($url);
        foreach ($this->_models as $key => $value) {
            foreach ($value as $subKey => $subValue) {
                $url = str_replace(
                    "{@{$subKey}}",
                    "",
                    $url
                );
                $endLength = strlen($url);
                if ($beginLength != $endLength)
                    return array(
                        'key' => $subKey,
                        'value' => $subValue
                    );
            }
        }
        return array();
    }

    public static function auth()
    {
        return isset($_SESSION['user'])
            ? $_SESSION['user']['role'] : '0';
    }

    public static function jsonError($key, $value)
    {
        $required = self::$_object->_map_language[$key];
        $requiredError = str_replace(
            ':attribute',
            $value,
            $required
        );
        return json_encode(
            array('error' => $requiredError)
        );
    }

    public static function jsonOk($key, $value)
    {
        $required = self::$_object->_map_language[$key];
        $requiredError = str_replace(
            ':attribute',
            $value,
            $required
        );
        return json_encode(
            array('ok' => $requiredError)
        );
    }
    
    public function replaceRequestModel($model)
    {
        $action = $model->action();
        $request = array();
        if ($model->action() == 'GET')
            $request = $_GET;
        else if ($model->action() == 'POST')
            $request = $_POST;
        else
            return;
        $rules = $model->rules();
        $required = $this->_map_language['required'];
        $requiredError = str_replace(
            ':attribute',
            $action,
            $required
        );
        if (count($request) != count($rules))
            die (
                json_encode(
                    array('error' => $requiredError)
                )
            );
        if (empty($rules))
            return;
        $return = array();
        foreach ($request as $key0 => $value0) {
            $status = false;
            foreach ($rules as $key => $value) {
                if ($key0 == $key) {
                    $status = true;
                    break;
                }
            }
            if (!$status) {
                $requiredError = str_replace(
                    ':attribute',
                    $key0,
                    $required
                );
                $return['error'][] = array(
                    $requiredError
                );
            }
            else {
                $list = json_decode(
                    "{{$value}}"
                );
                if (!empty($list))
                    foreach ($list as $key1 => $value1) {
                        if (
                            $key1 == 'required'
                            &&
                            $value1 == '1'
                            &&
                            empty($value0)
                        ) {
                            $required
                                = $this->_map_language['required'];
                            $requiredError = str_replace(
                                ':attribute',
                                $key0,
                                $required
                            );
                            $return['error'][] = array(
                                $requiredError
                            );
                        }
                        if (
                            $key1 == 'min'
                            &&
                            strlen($value0) < $value1
                        ) {
                            $required
                                = $this->_map_language['min']['string'];
                            $requiredError = str_replace(
                                ':attribute',
                                $key0,
                                $required
                            );
                            $requiredError = str_replace(
                                ':min',
                                $value1,
                                $requiredError
                            );
                            $return['error'][] = array(
                                $requiredError
                            );
                        }
                        if (
                            $key1 == 'max'
                            &&
                            strlen($value0) > $value1
                        ) {
                            $required
                                = $this->_map_language['max']['string'];
                            $requiredError = str_replace(
                                ':attribute',
                                $key0,
                                $required
                            );
                            $requiredError = str_replace(
                                ':max',
                                $value1,
                                $requiredError
                            );
                            $return['error'][] = array(
                                $requiredError
                            );
                        }
                        if ($key1 == 'regex') {
                            preg_match(
                                $value1,
                                $value0,
                                $matches
                            );
                            if (empty($matches)) {
                                $required
                                    = $this->_map_language['url'];
                                $requiredError = str_replace(
                                    ':attribute',
                                    $key0,
                                    $required
                                );
                                $return['error'][] = array(
                                    $requiredError
                                );
                            }
                        }
                    }
            }
        }
        if (!empty($return))
            die (json_encode($return));
        foreach ($request as $key0 => $value0)
            $model->$key0 = $value0;
    }
    
    static public function get($name, $path)
    {
        $norequest = false;
        if ($name == '/' && '/' == $_SERVER['REQUEST_URI'])
            $list = explode('@', $path);
        else {
            $inc = 0;
            
            $url = $name;

            if (!empty(self::$_object->_patterns))
                foreach (
                    self::$_object->_patterns
                    as $key => $value
                ) {
                    $key0 = '';
                    $value0 = '';
                    foreach (
                        $value
                        as $key0 => $value0
                    ) { }
                    $sizeBegin = strlen($url);
                    if ('norequest' != $key0)
                        $url = str_replace(
                            "{{$key0}}",
                            "({$value0})",
                            $url
                        );
                    else
                        $url = str_replace(
                            "{{$key0}}",
                            "{$value0}",
                            $url
                        );
                    $sizeEnd = strlen($url);
                    if ($sizeBegin != $sizeEnd) {
                        if ('norequest' != $key0)
                            ++$inc;
                        else
                            $norequest = true;
                    }
                }
            
            $lengthObjectBegin = strlen(
                $_SERVER['REQUEST_URI']
            );
            $requestUrl = substr(
                $_SERVER['REQUEST_URI'],
                0,
                strpos($_SERVER['REQUEST_URI'], '?')
            );
            $lengthObjectEnd = strlen($requestUrl);
            if ($lengthObjectBegin != $lengthObjectEnd) {
                $requestUrl = substr(
                    $_SERVER['REQUEST_URI'],
                    0,
                    strlen($_SERVER['REQUEST_URI'])
                );
            }

            if ($inc == 0) {
                $model = self::$_object->startModels($url);
                if (!empty($model))
                    $url = str_replace(
                        "{@" . $model['key'] . "}",
                        "",
                        $url
                    );
                if ($requestUrl != $url)
                    return;
            }
            else
                $model = self::$_object->startModels($url);
            
            if (!empty($model))
                $url = str_replace(
                    "{@" . $model['key'] . "}",
                    "",
                    $url
                );
            
            preg_match(
                $url . '/',
                $requestUrl . '/',
                $matches
            );
            
            if (empty($matches))
                return;
            
            $list = explode('@', $path);
        }
        
        require_once(self::$_object->_root_path
            . self::$_object->_controllers_path
            . $list[0] . '.php');
        
        $controller = '\\' . self::$_object->_controllers_name
            . '\\' . $list[0] . '\\' . $list[0];
        
        $controller = new $controller();
        
        if (!empty($matches)) {
            $arguments = array();
            $inc = 0;
            foreach ($matches as $key => $value) {
                if ($inc > 0)
                    $arguments[] = $value;
                ++$inc;
            }
            if (!empty($model)) {
                if (ucfirst($model['key']) == 'Userslogin')
                    require_once(
                        self::$_object->_root_path
                        . self::$_object->_request_path
                        . 'UsersLogin'
                        . self::$_object->_request_name . '.php'
                    );
                else if (ucfirst($model['key']) == 'Messagesview')
                    require_once(
                        self::$_object->_root_path
                        . self::$_object->_request_path
                        . 'MessagesView'
                        . self::$_object->_request_name . '.php'
                    );
                else if (ucfirst($model['key']) == 'Usersupdate')
                    require_once(
                        self::$_object->_root_path
                        . self::$_object->_request_path
                        . 'UsersUpdate'
                        . self::$_object->_request_name . '.php'
                    );
                else
                    require_once(
                        self::$_object->_root_path
                        . self::$_object->_request_path
                        . ucfirst($model['key'])
                        . self::$_object->_request_name . '.php'
                    );
                $requestModel = '\\' . $model['value'];
                $requestModel = new $requestModel();
                $arguments[] = &$requestModel;
                if (!$norequest)
                    self::$_object->replaceRequestModel(
                        $requestModel
                    );
                self::$_object->_status_request = true;
            }
            call_user_func_array(
                array($controller, $list[1]),
                $arguments
            );
        }
        else {
            if (!empty($model)) {
                require_once(
                    self::$_object->_root_path
                    . self::$_object->_request_path
                    . ucfirst($model['key'])
                    . self::$_object->_request_name . '.php'
                );
                $requestModel = '\\' . $model['value'];
                $requestModel = new $requestModel();
                $arguments[] = &$requestModel;
                if (!$norequest)
                    self::$_object->replaceRequestModel(
                        $requestModel
                    );
                self::$_object->_status_request = true;
                call_user_func_array(
                    array($controller, $list[1]),
                    $arguments
                );
            }
            else
                $controller->$list[1]();
        }
        
        exit;
    }
    
    static public function view()
    {
        require_once(self::$_object->_root_path
            . self::$_object->_controllers_path
            . self::$_object->_controller_default . '.php');
        $controller = '\\' . self::$_object->_controllers_name
            . '\\' . self::$_object->_controller_default
            . '\\' . self::$_object->_controller_default;
        $controller = new $controller();
        
        exit;
    }

    static public function error($error)
    {
        require_once(self::$_object->_root_path
            . self::$_object->_controllers_path
            . self::$_object->_controller_default . '.php');
        $controller = '\\' . self::$_object->_controllers_name
            . '\\' . self::$_object->_controller_default
            . '\\' . self::$_object->_controller_default;
        $controller = new $controller($error);
        
        exit;
    }

    static public function getContent($session, $url = '/count-messages/')
    {
        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"Accept-language: en\r\n" .
                    "Cookie: foo=bar\r\n"
            )
        );
        $context = stream_context_create($opts);
        $url = 'http://'
            . $_SERVER['HTTP_HOST']
            . $url
            . $session;
        $file = file_get_contents(
            $url,
            false,
            $context
        );
        return $file;
    }
}

new Main();
