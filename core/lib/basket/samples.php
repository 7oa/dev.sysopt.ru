<?php

namespace Core\Main;

class Samples extends DataManager {

    protected $items = array();

    function __construct() {
        $items = $this->getItems(User::getID());

        if ($items) {
            foreach ($items as $arItem)
                $this->items[$arItem['PRODUCT_ID']] = $arItem;

        } else
            return false;
    }

    public static function getTable() {
        return 'samples';
    }

    public static function getFieldMap() {
        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
            ),
            'ROOT' => array(
                'data_type' => 'integer',
                'primary' => false,
                'autocomplete' => false,
            ),
            'S_NAME' => array(
                'data_type' => 'string',
                'required' => true,
            ),
            'TIMESTAMP_X' => array(
                'data_type' => 'datetime',
                'required' => true,
            ),
            'USER_ID' => array(
                'data_type' => 'integer',
                'required' => true,
            ),
            'PRODUCT_ID' => array(
                'data_type' => 'string',
                'required' => true,
            ),
            'ART' => array(
                'data_type' => 'string',
                'required' => true,
            ),
            'NAME' => array(
                'data_type' => 'string',
                'required' => true,
            ),
            'QUANTITY' => array(
                'data_type' => 'integer',
                'required' => true,
            )
        );
    }

    public static function getItems($ID) {
        $parameters['filter'] = array('USER_ID' => $ID);
        $res = static::getList($parameters);
        $dbResult = $res->fetchAll();

        return $dbResult;
    }

    public static function getSampleDetailItems($ID,$ROOT) {
        $parameters['filter'] = array('USER_ID' => $ID, 'ROOT' => $ROOT);
        $res = static::getList($parameters);
        $dbResult = $res->fetchAll();

        return $dbResult;
    }

    public static function getGroupItems($ID) {
        $connect = DataBase::getConnection();
        $select = $connect->query("SELECT * FROM `samples` WHERE `USER_ID` = '$ID' AND `ROOT` = '0'");
        return $select->fetchAll();
    }

    public static function checkItem($ID) {
        $parameters['filter'] = array('USER_ID' => User::getID(), 'PRODUCT_ID' => $ID);
        $parameters['select'] = array('ID', 'QUANTITY');
        $res = static::getList($parameters);
        if ($res->rowsCount() > 0)
            return $res->fetchRaw();
        else
            return false;
    }

    public static function checkSample($name) {
        $user_id = User::getID();

        $connect = DataBase::getConnection();
        $check = $connect->query("SELECT * FROM `samples` WHERE `S_NAME` = '$name' AND `ROOT` = '0' AND `USER_ID` = '$user_id'");
        $check = $check->fetchRaw();

        if ($check == false) {
            $data = array(
                "PRODUCT_ID" => "0",
                "S_NAME" => $name,
                "ROOT" => "0",
                "USER_ID" => $user_id,
                "ART" => "0",
                "NAME" => "0",
                "QUANTITY" => "0"
            );
            $id = static::add($data);
        } else $id = false;

        return $id;
    }

    public static function addItemByProduct($data) {
        $id = static::add($data);
        $data['ID'] = $id;
        $returnData = $data;
        return $returnData;
    }

    public static function add($data) {
        return parent::add($data);
    }

    public static function delete($ID) {
        parent::delete($ID);
    }

    public function formatePrice($price) {
        return number_format($price, 2, '.', ' ');
    }

}
