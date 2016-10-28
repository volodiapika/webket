<?php

namespace Core\Ormmodel;

use mysqli;
use ReflectionObject;
use ReflectionProperty;
use ReflectionClass;

abstract class Ormmodel
{
    protected static $conn;
    protected static $database;
    protected static $webket = 'id';
    
    private $reflectionObject;
    private $loadMethod;
    private $loadData;
    private $modifiedFields = array();
    private $isNew = false;
    
    protected $parentObject;
    protected $ignoreKeyOnUpdate = true;
    protected $ignoreKeyOnInsert = true;
    
    const FILTER_IN_PREFIX = 'filterIn';
    const FILTER_OUT_PREFIX = 'filterOut';
    
    const LOAD_BY_WEBKET = 1;
    const LOAD_BY_ARRAY = 2;
    const LOAD_NEW = 3;
    const LOAD_EMPTY = 4;

    const FETCH_ONE = 1;
    const FETCH_MANY = 2;
    const FETCH_NONE = 3;

    static private $_tableName;
    
    final public function __construct(
        $data = null,
        $method = self::LOAD_EMPTY
    )
    {
        $this->loadData = $data;
        $this->loadMethod = $method;
        
        switch ($method) {
            case self::LOAD_BY_WEBKET:
                $this->loadByWEBKET();
                break;

            case self::LOAD_BY_ARRAY:
                $this->loadByArray();
                break;

            case self::LOAD_NEW:
                $this->loadByArray();
                $this->insert();
                break;

            case self::LOAD_EMPTY:
                $this->hydrateEmpty();
                break;
        }

        $this->initialise();
    }

    public static function setTableName($tableName)
    {
        Ormmodel::$_tableName = $tableName;
    }

    public static function useConnection(
        mysqli $conn, $database
    )
    {
        self::$conn = $conn;
        self::$database = $database;
        
        $conn->select_db($database);
    }

    public static function getConnection()
    {
        return self::$conn;
    }

    public function getLoadMethod()
    {
        return $this->loadMethod;
    }

    public function getLoadData()
    {
        return $this->loadData;
    }

    private function loadByWEBKET()
    {
        $this->{self::getTableWEBKET()} = $this->loadData;
        
        $this->hydrateFromDatabase();
    }

    private function loadByArray()
    {
        foreach ($this->loadData AS $key => $value)
            $this->{$key} = $value;

         $this->executeOutputFilters();
    }

    private function hydrateEmpty()
    {
        if (
            isset($this->erLoadData)
            && is_array($this->erLoadData)
        )
            foreach ($this->erLoadData AS $key => $value)
                $this->{$key} = $value;

        foreach ($this->getColumnNames() AS $field)
            $this->{$field} = null;

        $this->isNew = true;
    }

    private function hydrateFromDatabase ()
    {
        $sql = sprintf(
            "SELECT * FROM `%s`.`%s` WHERE `%s` = '%s';",
            self::getDatabaseName(),
            self::getTableName(),
            self::getTableWEBKET(),
            $this->id()
        );
        $result = self::getConnection()->query($sql);
                
        $result->close();
        
        $this->executeOutputFilters();
    }

    public static function getDatabaseName ()
    {
        $className = get_called_class();
        
        return $className::$database;
    }

    public static function getTableName ()
    {
        return Ormmodel::$_tableName;
    }

    public static function getTableWEBKET()
    {
        $className = get_called_class();

        return $className::$webket;
    }

    public function id ()
    {
        return $this->{self::getTableWEBKET()};
    }

    public function isNew ()
    {
        return $this->isNew;
    }

    public function preInsert ()
    {
    }

    public function postInsert ()
    {
    }

    public function initialise ()
    {
    }

    private function executeOutputFilters ()
    {
        $r = new \ReflectionClass(get_class($this));
    
        foreach ($r->getMethods() AS $method)
            if (
                substr(
                    $method->name,
                    0,
                    strlen(self::FILTER_OUT_PREFIX)
                )
                ==
                self::FILTER_OUT_PREFIX
            )
                $this->{$method->name}();
    }

    private function executeInputFilters ($array)
    {
        $r = new \ReflectionClass(get_class($this));
    
        foreach ($r->getMethods() AS $method)
            if (
                substr(
                    $method->name,
                    0,
                    strlen(self::FILTER_IN_PREFIX)
                )
                ==
                self::FILTER_IN_PREFIX
            )
                $array = $this->{$method->name}($array);

        return $array;
    }

    public function save ()
    {
        if ($this->isNew())
            $this->insert();
        else
            $this->update();
    }

    private function insert ()
    {
        $array = $this->get();

        $this->preInsert($array);

        $array = $this->executeInputFilters($array);
        
        $fieldNames
            = $fieldMarkers
            = $types
            = $values
            = array();
        
        foreach ($array AS $key => $value) {
            $fieldNames[] = sprintf('`%s`', $key);
            $fieldMarkers[] = '?';
            $types[] = $this->parseValueType($value);
            $values[] = &$array[$key];
        }
        
        $sql = sprintf(
            "INSERT INTO `%s`.`%s` (%s) VALUES (%s)",
            self::getDatabaseName(),
            self::getTableName(),
            implode(', ', $fieldNames),
            implode(', ', $fieldMarkers)
        );
        
        $stmt = self::getConnection()->prepare($sql);

        if (!$stmt)
            throw new \Exception(
                self::getConnection()->error."\n\n".
                $sql
            );
        
        call_user_func_array(
            array(
                $stmt,
                'bind_param'
            ),
            array_merge(
                array(
                    implode(
                        $types
                    )
                ),
            $values)
        );
        $stmt->execute();

        if ($stmt->error)
            throw new \Exception($stmt->error."\n\n".$sql);

        if ($stmt->insert_id)
            $this->{self::getTableWEBKET()} = $stmt->insert_id;

        $this->isNew = false;

        $this->hydrateFromDatabase($stmt->insert_id);

        $this->postInsert();
    }

    public function update ()
    {
        if ($this->isNew())
            throw new \Exception('Unable to update object, record is new.');

        $webket = self::getTableWEBKET();
        $id = $this->id();

        $array = $this->executeInputFilters($this->get());

        $array = array_intersect_key($array, array_flip($this->getColumnNames()));

        if ($this->ignoreKeyOnUpdate === true)
            unset($array[$webket]);

        $fields = $types = $values = array();

        foreach ($array AS $key => $value)
        {
            $fields[] = sprintf('`%s` = ?', $key);
            $types[] = $this->parseValueType($value);
            $values[] = &$array[$key];
        }

        $types[] = 'i';
        $values[] = &$id;

        $sql = sprintf(
            "UPDATE `%s`.`%s` SET %s WHERE `%s` = ?",
            self::getDatabaseName(),
            self::getTableName(),
            implode(', ', $fields),
            $webket
        );

        $stmt = self::getConnection()->prepare($sql);

        if (!$stmt)
            throw new \Exception(
                self::getConnection()->error."\n\n".$sql
            );

        call_user_func_array(
            array($stmt, 'bind_param'),
            array_merge(
                array(implode($types)),
                $values
            )
        );
        $stmt->execute();

        if ($stmt->error)
            throw new \Exception($stmt->error."\n\n".$sql);

        $this->modifiedFields = array();
    }

    public function delete ()
    {
        if ($this->isNew())
            throw new \Exception(
                "Unable to delete object, record is new "
                . "(and therefore doesn't exist in the database)."
            );

        $sql = sprintf(
            "DELETE FROM `%s`.`%s` WHERE `%s` = ?",
            self::getDatabaseName(),
            self::getTableName(),
            self::getTableWEBKET()
        );

        $stmt = self::getConnection()->prepare($sql);

        if (!$stmt)
            throw new \Exception(self::getConnection()->error);
        
        $id = $this->id();
        $stmt->bind_param('i', $id);
        $stmt->execute();

        if ($stmt->error)
            throw new \Exception($stmt->error."\n\n".$sql);
    }

    public function getColumnNames ()
    {
        $conn = self::getConnection();
        $result = $conn->query(
            sprintf(
                "DESCRIBE %s.%s;",
                self::getDatabaseName(),
                self::getTableName()
            )
        );
        
        if ($result === false)
            throw new \Exception(
                sprintf(
                    'Unable to fetch the column names. %s.',
                    $conn->error
                )
            );

        $ret = array();

        while ($row = $result->fetch_assoc())
            $ret[] = $row['Field'];

        $result->close();

        return $ret;
    }

    private function parseValueType ($value)
    {
        if (is_int($value))
            return 'i';

        if (is_double($value))
            return 'd';

        return 's';
    }

    public function parent ($obj = false)
    {
        if ($obj && is_object($obj))
            $this->parentObject = $obj;

        return $this->parentObject;
    }

    public function revert ($return = false)
    {
        if ($return) {
            $ret = clone $this;
            $ret->revert();

            return $ret;
        }

        $this->hydrateFromDatabase();
    }

    public function get ($fieldName = false)
    {
        if ($fieldName === false)
            return self::convertObjectToArray($this);

        return $this->{$fieldName};
    }

    public static function convertObjectToArray ($object)
    { 
        if (!is_object($object))
            return $object;

        $array = array();
        $r = new ReflectionObject($object);

        foreach (
            $r->getProperties(ReflectionProperty::IS_PUBLIC)
            AS $key => $value
        ) {
            $key = $value->getName();
            $value = $value->getValue($object);
        
            $array[$key] = is_object($value)
                ? self::convertObjectToArray($value) : $value;
        }

        return $array;
    }

    public function set ($fieldName, $newValue)
    {
        if ($this->{$fieldName} != $newValue)
            $this->modifiedFields($fieldName, $newValue);

        $this->{$fieldName} = $newValue;
        
        return $this;
    }

    public function isModified ()
    {
        return (
            count($this->modifiedFields) > 0
        ) ? $this->modifiedFields : false;
    }

    private function modifiedFields ($fieldName, $newValue)
    {
        if (!isset($this->modifiedFields[$fieldName])) {
            $this->modifiedFields[$fieldName] = $newValue;

            return;
        }

        if (!is_array($this->modifiedFields[$fieldName]))
            $this->modifiedFields[$fieldName]
                = array($this->modifiedFields[$fieldName]);

        $this->modifiedFields[$fieldName][] = $newValue;
    }

    public static function sql ($sql, $return = Ormmodel::FETCH_MANY)
    {
        $sql = str_replace(
            array(':database', ':table', ':webket'),
            array(self::getDatabaseName(),
            self::getTableName(),
            self::getTableWEBKET()),
            $sql
        );

        $result = self::getConnection()->query($sql);
        
        if (!$result)
            throw new \Exception(
                sprintf(
                    'Unable to execute SQL statement. %s',
                    self::getConnection()->error
                )
            );
        
        if ($return === Ormmodel::FETCH_NONE)
            return;

        $ret = array();

        while ($row = $result->fetch_assoc())
            $ret[] = call_user_func_array(
                array(
                    get_called_class(),
                    'hydrate'
                ),
                array($row)
            );

        $result->close();

        if ($return === Ormmodel::FETCH_ONE)
            $ret = isset($ret[0]) ? $ret[0] : null;

        return $ret;
    }

    public static function count ($sql)
    {
        $count = self::sql($sql, Ormmodel::FETCH_ONE);
        
        return $count > 0 ? $count : 0;
    }

    public static function truncate ()
    {
        self::sql(
            'TRUNCATE :database.:table',
            Ormmodel::FETCH_NONE
        );
    }

    public static function all ()
    {
        return self::sql(
            "SELECT * FROM :database.:table"
        );
    }

    public static function countAll ()
    {
        return self::sql(
            "SELECT COUNT(*) as count FROM :database.:table"
        );
    }

    public static function retrieveByWEBKET ($webket)
    {
        if (!is_numeric($webket))
            throw new \InvalidArgumentException(
                'The WEBKET must be an integer.'
            );

        $reflectionObj = new ReflectionClass(get_called_class());

        return $reflectionObj->newInstanceArgs(
            array($webket, Ormmodel::LOAD_BY_WEBKET)
        );
    }

    public static function hydrate ($data)
    {
        if (!is_array($data))
            throw new \InvalidArgumentException(
                'The data given must be an array.'
            );

        $reflectionObj = new ReflectionClass(
            get_called_class()
        );

        return $reflectionObj->newInstanceArgs(
            array($data, Ormmodel::LOAD_BY_ARRAY)
        );
    }

    public static function __callStatic ($name, $args)
    {
        $class = get_called_class();

        if (substr($name, 0, 10) == 'retrieveBy') {
            $field = strtolower(
                preg_replace(
                    '/\B([A-Z])/',
                    '_${1}',
                    substr($name, 10)
                )
            );
            array_unshift($args, $field);

            return call_user_func_array(
                array($class, 'retrieveByField'),
                $args
            );
        }

        throw new \Exception(
            sprintf(
                'There is no static method named "%s" in the class "%s".',
                $name,
                $class
            )
        );
    }

    public static function retrieveByField (
        $field,
        $value,
        $return = Ormmodel::FETCH_MANY
    )
    {
        if (!is_string($field))
            throw new \InvalidArgumentException(
                'The field name must be a string.'
            );

        $operator = (strpos($value, '%') === false)
            ? '=' : 'LIKE';

        $sql = sprintf(
            "SELECT * FROM :database.:table WHERE %s %s '%s'",
            $field,
            $operator,
            $value
        );

        if ($return === Ormmodel::FETCH_ONE)
            $sql .= ' LIMIT 0,1';

        return self::sql($sql, $return);
    }

    public static function buildSelectBoxValues ($where = null)
    {
        $sql = 'SELECT * FROM :database.:table';

        if (is_string($where))
            $sql .= sprintf(" WHERE %s", $where);
    
        $values = array();
        
        foreach (self::sql($sql) AS $object)
            $values[$object->id()] = (string) $object;
    
        return $values;
    }
}
