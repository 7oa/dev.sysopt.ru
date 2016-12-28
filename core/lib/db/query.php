<?php

namespace Core\Main;

use \Core\Main\DataBase;

class Query {

    protected
            $entity = null,
            $fields = array(),
            $table = null;
    protected
            $select = array(),
            $order = array(),
            $group = array(),
            $filter = array(),
            $limit = null,
            $offset = null;
    protected
            $connection = null;
    static $triple_char = array(
        "!><" => "NB", //not between
        "!=%" => "NM", //not Identical by like
        "!%=" => "NM", //not Identical by like
    );
    static $double_char = array(
        "!=" => "NI", //not Identical
        "!%" => "NS", //not substring
        "><" => "B", //between
        ">=" => "GE", //greater or equal
        "<=" => "LE", //less or equal
        "=%" => "M", //Identical by like
        "%=" => "M", //Identical by like
        "!@" => "NIN", //Identical by like
    );
    static $single_char = array(
        "=" => "I", //Identical
        "%" => "S", //substring
        "?" => "?", //logical
        ">" => "G", //greater
        "<" => "L", //less
        "!" => "N", // not field LIKE val
        "@" => "IN" // IN (new SqlExpression)
    );

    function __construct($source) {
        $this->fields = $source::getFieldMap();
        $this->table = $source::getTable();
    }

    public function execute() {
        $query = $this->buildQuery();
        $connection = DataBase::getConnection();
        $res = $connection->query($query);
        return $res;
    }

    public function add(array $data) {
        $insert = $this->prepareInsert($data);

        $query = "INSERT INTO " . $this->table . "(" . $insert[0] . ") " .
                "VALUES (" . $insert[1] . ")";
        
        $connection = DataBase::getConnection();
        $res = $connection->query($query);

        return $res->getInsertedId();
    }

    public function update($primary, array $data) {
        $update = $this->prepareUpdate($primary, $data);

        $query = "UPDATE " . $this->table . " SET " . $update[0] . " WHERE " . $update[1];
        $connection = DataBase::getConnection();
        $res = $connection->query($query);
        $connection->setAffectedRowsCount();

        return $res;
    }
    
    public function delete($primary) {
        $update = $this->prepareDelete($primary);

        $query = "DELETE FROM " . $this->table . " WHERE " . $update[0];
        $connection = DataBase::getConnection();
        $res = $connection->query($query);
        $res->setAffectedRowsCount();

        return $res;
    }
    
    public function setFilter(array $params) {
        $this->filter = $params;
    }

    public function setSelect(array $params) {
        $this->select = $params;
    }

    public function setOrder(array $params) {
        $this->order = $params;
    }

    public function setGroup(array $params) {
        $this->group = $params;
    }

    public function setLimit(array $params) {
        $this->limit = $params;
    }

    public function setOffset(array $params) {
        $this->offset = $params;
    }

    protected function buildQuery() {

        $filter = $this->buildFilter();
        $select = $this->buildSelect();
        $order = $this->buildOrder();
        $group = $this->buildGroup();

        $build_parts = array_filter(array(
            'SELECT' => $select,
            'FROM' => $this->table,
            'WHERE' => $filter,
            'ORDER BY' => $order,
            'GROUP BY' => $group
        ));

        foreach ($build_parts as $k => &$v) {
            $v = $k . ' ' . $v;
        }

        $query = join("\n", $build_parts);

        return $query;
    }

    protected function convertToDb($key, $value) {
        switch ($this->fields[$key]['data_type']) {
            case 'integer':
                return $value;
            case 'string':
                return "'" . $value . "'";
            case 'datetime':
                $field = $this->modifyDateField($value);
                return "'" . $field . "'";
            case 'float':
                return floatval($value);
        }
    }

    protected function modifyDateField($value) {
        if (is_int($value))
            $field = date('Y-m-d  H:i:s', $value);
        elseif (is_string($value))
            $field = date('Y-m-d  H:i:s', $value);
        elseif ($value instanceof \DateTime)
            $field = $value->format('Y-m-d H:i:s');

        return $field;
    }

    protected function buildOperation($key) {
        if (isset(self::$triple_char[$op = substr($key, 0, 3)]))
            return Array("FIELD" => substr($key, 3), "OPERATION" => $op);
        elseif (isset(self::$double_char[$op = substr($key, 0, 2)]))
            return Array("FIELD" => substr($key, 2), "OPERATION" => $op);
        elseif (isset(self::$single_char[$op = substr($key, 0, 1)]))
            return Array("FIELD" => substr($key, 1), "OPERATION" => $op);
        else
            return Array("FIELD" => $key, "OPERATION" => "="); // field LIKE val
    }

    protected function buildSelect() {
        if (!empty($this->select))
            return $select = join(',', $this->select);
        else
            return '*';
    }

    protected function buildFilter() {
        $sqlFilter = array();
        foreach ($this->filter as $k => $v):
            $operation = $this->buildOperation($k);
            $element = $this->convertToDb($operation['FIELD'], $v);
            $sqlFilter[] = $operation['FIELD'] . $operation['OPERATION'] . $element;
        endforeach;
        return join(' AND ', $sqlFilter);
    }

    protected function buildOrder() {
        $sqlOrder = array();
        foreach ($this->order as $k => $v):
            $sqlOrder[] = $k . ' ' . $v;
        endforeach;
        return join('\n', $sqlOrder);
    }

    protected function buildGroup() {
        if (!empty($this->group))
            return $select = join(',', $this->group);
    }

    protected function prepareInsert($data) {

        foreach ($data as $columnName => $tableField) {
            if (isset($this->fields[$columnName]) || array_key_exists($columnName, $this->fields)) {
                $columns[] = $columnName;
                $values[] = $this->convertToDb($columnName, $tableField);
            }
        }
        return array(
            implode(", ", $columns),
            implode(", ", $values)
        );
    }

    protected function prepareUpdate($primary, $data) {

        foreach ($data as $columnName => $tableField) {
            if (isset($this->fields[$columnName]) || array_key_exists($columnName, $this->fields)) {
                $update[] = $columnName . ' = ' . $this->convertToDb($columnName, $tableField);
            }
        }
        $id = array();
        if (is_array($primary)) {
            foreach ($primary as $columnName => $tableField) {
                $operation = $this->buildOperation($columnName);
                $columnName = $operation['FIELD'];
                if (isset($this->fields[$columnName]) || array_key_exists($columnName, $this->fields)) {
                    $id[] = $columnName . " {$operation['OPERATION']} " . $this->convertToDb($columnName, $tableField);
                }
            }
        } elseif (isset($this->fields['ID']) && intval($primary) > 0)
            $id[] = 'ID=' . $primary;
        else
            throw new \Exception("У таблицы {$this->table} отсутствует первичный ключ или первичный ключ не является числом");


        return array(implode(", ", $update), implode(" AND ", $id));
    }
    
    protected function prepareDelete($primary) {

        $id = array();
        if (is_array($primary)) {
            foreach ($primary as $columnName => $tableField) {
                $operation = $this->buildOperation($columnName);
                $columnName = $operation['FIELD'];
                if (isset($this->fields[$columnName]) || array_key_exists($columnName, $this->fields)) {
                    $id[] = $columnName . " {$operation['OPERATION']} " . $this->convertToDb($columnName, $tableField);
                }
            }
        } elseif (isset($this->fields['ID']) && intval($primary) > 0)
            $id[] = 'ID=' . $primary;
        else
            throw new \Exception("У таблицы {$this->table} отсутствует первичный ключ или первичный ключ не является числом");


        return array(implode(" AND ", $id));
    }
}
