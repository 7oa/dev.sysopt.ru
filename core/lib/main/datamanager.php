<?php

namespace Core\Main;

use Core\Main\Soap;

abstract class DataManager {

    static $instance = null;
    protected $soap = null;

    function __construct($soap = true) {
        if ($soap)
            $this->soap = new Soap;
    }

    public static function getInstance($soap = true) {
        $class = get_called_class();
        if (!isset(static::$instance[$class]))
            static::$instance[$class] = new static($soap);

        return static::$instance[$class];
    }

    public function getResult($function_name, $arguments) {
        if (!$this->soap)
            return false;

        $result = $this->soap->call($function_name, $arguments);
        
        return $result;
    }

    public static function getTable() {
        return null;
    }

    public static function getFieldMap() {
        return array();
    }

    public static function query($class) {
        return new Query($class);
    }

    public static function getByPrimary($primary) {
        $parameters = array('filter' => array('ID' => $primary));
        $res = static::getList($parameters);
        return $res->fetchRaw();
    }

    public static function getByExternal($id) {
        $parameters = array('filter' => array('EXTERNAL' => $id));
        $res = static::getList($parameters);
        return $res->fetchRaw();
    }

    public static function getList($parameters) {
        $class = get_called_class();
        $db = static::query($class);

        foreach ($parameters as $param => $value) {
            switch ($param) {
                case 'select':
                    $db->setSelect($value);
                    break;
                case 'filter':
                    $db->setFilter($value);
                    break;
                case 'order';
                    $db->setOrder($value);
                    break;
                case 'group';
                    $db->setGroup($value);
                    break;
                case 'limit':
                    $db->setLimit($value);
                    break;
                case 'offset':
                    $db->setOffset($value);
                    break;
                default:
                    throw new Exception("Unknown parameter: " . $param, $param);
            }
        }
        return $db->execute();
    }

    public static function add($data) {
        $class = get_called_class();
        $db = static::query($class);
        $ID = $db->add($data);
        return $ID;
    }

    public static function update($primary, $data) {
        $class = get_called_class();
        $db = static::query($class);
        $ID = $db->update($primary, $data);
        return $ID;
    }

    public static function delete($primary) {
        $class = get_called_class();
        $db = static::query($class);
        $ID = $db->delete($primary);
        return $ID;
    }

}
