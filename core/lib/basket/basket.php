<?php

namespace Core\Main;

class Basket extends DataManager {

    protected $items = array(),
            $basketPrice = null,
            $itemsCount = null;

    function __construct() {
        $items = $this->getItems(User::getID());

        if ($items) {
            foreach ($items as $arItem)
                $this->items[$arItem['PRODUCT_ID']] = $arItem;

            foreach ($this->items as &$arItem):
                $product = static::getActualPrice($arItem['PRODUCT_ID']);
                $arItem['PRICE'] = $product['Products']['price'];
                $price += $arItem['PRICE'] * $arItem['QUANTITY'];
                $arItem['FULL_PRICE'] = $arItem['PRICE'] * $arItem['QUANTITY'];
            endforeach;
            $this->basketPrice = $price;
            $this->itemsCount = sizeof($this->items);
        } else
            return false;
    }

    public static function getTable() {
        return 'basket';
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
            'PRICE' => array(
                'data_type' => 'float',
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
            $returnData = $data;
        }
        else
            $returnData = static::update($item['ID'], $data, $item, true, true);

        return $returnData;
    }

    public static function update($primaty, $data, $item = array(), $needRecalc = false, $returnData = false) {
        if ($needRecalc)
            $data['QUANTITY']+=$item['QUANTITY'];

        $price = static::getActualPrice($data['PRODUCT_ID']);
        $data['PRICE'] = $price['Products']['price'];

        parent::update($primaty, $data);

        if ($returnData)
            return $data;
    }

    public static function add($data) {
        return parent::add($data);
    }

    public static function delete($ID) {
        parent::delete($ID);
    }

    public function getItemsCount() {
        return $this->itemsCount;
    }

    public function getBasketItems() {
        return $this->items;
    }

    public function getPrice() {
        return $this->formatePrice($this->basketPrice);
    }

    public function formatePrice($price) {
        return number_format($price, 2, '.', ' ');
    }

}
