<?php

namespace Core\Orm;

use \WebKet\Main\Main;
use mysqli;
use \Core\Ormmodel\Ormmodel;

include Main::$_object->_root_path
    . Main::$_object->_core_path
    . Main::$_object->_ormmodel_path;

/**
* The core orm object class
*/
class Ormobject extends \Core\Ormmodel\Ormmodel { }

/**
* The core orm class
*/
class Orm
{
	
    private $_connection;
    private $_ormObject;

    public function request($request)
    {
        if (!empty($request))
            foreach ($request as $key => $value)
                $this->$key = $value;
    }

    private function makeObject($request, $model = array())
    {
        $this->request($request);
        
        $this->_connection = new mysqli(
            Main::$_object->_map_config['database']['host'],
            Main::$_object->_map_config['database']['user'],
            Main::$_object->_map_config['database']['password']
        );
        
        if ($this->_connection->connect_error)
            die(
                sprintf(
                    'Unable to connect to the database. %s',
                    $this->_connection->connect_error
                )
            );
        
        if (!empty($model))
            Ormobject::setTableName($model);
        else
            Ormobject::setTableName(
                strtolower(
                    implode(
                        '\\',
                        array_unique(
                            explode(
                                '\\',
                                str_replace(
                                    'Models\\',
                                    '',
                                    get_class($this)
                                )
                            )
                        )
                    )
                )
            );
        
        Ormmodel::useConnection(
            $this->_connection,
            Main::$_object->_map_config['database']['database']
        );
        
        $this->_ormObject = new Ormobject();
        
        foreach ($request as $key => $value)
            $this->_ormObject->$key = $value;
    }
    
    public function save($request, $model = array())
    {
        $this->makeObject($request, $model);
        $this->_ormObject->save($model);
    }
    
    public function update($request)
    {
        $this->makeObject($request);
        $this->_ormObject = Ormobject::retrieveByWEBKET(
            $this->_ormObject->id()
        );
        foreach ($request as $key => $value)
            $this->_ormObject->$key = $value;
        $this->_ormObject->save();
    }
    
    public function remove($request)
    {
        $this->makeObject($request);
        $this->_ormObject = Ormobject::retrieveByWEBKET(
            $this->_ormObject->id()
        );
        $this->_ormObject->delete();
    }
    
    public function get($request, $key)
    {
        $this->makeObject($request);
        return $this->_ormObject->$key;
    }

    public function all($request, $model = array())
    {
        $this->makeObject($request, $model);
        return $this->_ormObject->all();
    }

    public function allSelect($request, $model = array())
    {
        $this->makeObject($request, $model);
        $this->_ormObject = Ormobject::retrieveByWEBKET(
            $this->_ormObject->id()
        );
        return $this->_ormObject->all();
    }
    
    public function countAll($request)
    {
        $this->makeObject($request);
        $this->_ormObject = Ormobject::retrieveByWEBKET(
            $this->_ormObject->id()
        );
        $counts = $this->_ormObject->countAll();
        foreach ($counts as $key => $value)
            return $value->count;
    }
    
}
