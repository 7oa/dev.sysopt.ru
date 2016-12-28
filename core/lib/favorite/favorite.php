<?php

namespace Core\Main;

use Core\Main\DataManager,
    Core\Main\User,
    Core\Main\Soap;

class Favorite extends DataManager {

    protected $items = array();

    function __construct() {
        $items = $this->getItems(User::getID());

        if ($items) {
            foreach ($items as $arItem)
                $this->items[$arItem['PRODUCT_ID']] = $arItem;

            foreach ($this->items as &$arItem):
                $product = static::getActualPrice($arItem['PRODUCT_ID']);
                $arItem['PRICE'] = $product['Products']['price'];
                $arItem['QUANTITY'] = $product['Products']['quantity'];
            endforeach;
        } else
            return false;
    }

    public static function getTable() {
        return 'favorits';
    }

    public static function getFieldMap() {
        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
            ),
            'TIMESTAMP_X' => array(
                'data_type' => 'datetime',
                'required' => true,
            ),
            'USER_ID' => array(
                'data_type' => 'integer',
                'required' => true,
            ),
            'NAME' => array(
                'data_type' => 'string',
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
            'PRICE' => array(
                'data_type' => 'string',
                'required' => true,
            ),
            'QUANTITY' => array(
                'data_type' => 'integer',
                'required' => true,
            ),
            'TYPE' => array(
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


    public static function checkItem($ID) {
        $parameters['filter'] = array('USER_ID' => User::getID(), 'PRODUCT_ID' => $ID);
        $parameters['select'] = array('ID', 'QUANTITY');
        $res = static::getList($parameters);
        if ($res->rowsCount() > 0)
            return $res->fetchRaw();
        else
            return false;
    }

    protected static function getActualPrice($product) {
        $USER_ID = User::getID();
        $arUser = User::getByID($USER_ID);
        $price_id=$arUser["PRICE"];
        //$def_price=$arUser["SHOWDEFAULTPRICE"];
        $group_det="false";//$arUser["PRICEGROUPDETAL"];
        $agreement=$arUser["AGREEMENT"];
        $soap = new Soap;
        $findParams = array('req' => "code", 'value' => $product, 'price_id' => $price_id, 'priceGroupDetal' => $group_det, 'agreement_id' => $agreement);
        $find = $soap->call('FindProductsBy', $findParams);

        return $find;
    }

    public static function addItemByProduct($data) {
        $item = static::checkItem($data['PRODUCT_ID']);
        if ($item === false) {
            $id = static::add($data);
            $data['ID'] = $id;
            /*$returnData = $data;*/
            $nType = 1;
        }
        else{
            static::delete($item['ID']);//static::update($item['ID'], $data, $item, true, true);
            $nType = 0;
        }


        return $nType;
    }

    public static function add($data) {
        return parent::add($data);
    }

    public static function delete($ID) {
        parent::delete($ID);
    }
    public function getFavotiteItems() {
        return $this->items;
    }

    public function formatePrice($price) {
        return number_format($price, 2, '.', ' ');
    }

}
