<?php

include $_SERVER['DOCUMENT_ROOT'] . '/core/loader/prolog_before.php';

use Core\Main\User,
    Core\Main\Basket,
    Core\Main\Samples,
    Core\Main\Template;

$data = $_POST;
$USER_ID = User::getID();

$product = array(
    "PRODUCT_ID" => $data['id'],
    "ART" => $data['art'],
    "NAME" => $data['name'],
    "PRICE" => $data['price'],
    "QUANTITY" => $data['cnt'],
    "USER_ID" => $USER_ID
);

switch ($data['TYPE']) {
    case 'add':
        $result = Basket::addItemByProduct($product);
        $basket = Basket::getInstance(false);
        Template::includeTemplate('basket_items', $basket);
        break;
    case 'update':
        $result = Basket::update($_POST["basketid"], $product);
        $basket = Basket::getInstance(false);
        echo $basket->getPrice();
        break;
    case 'delete':
        Basket::delete($_POST["id"]);
        break;
    case 'refresh':
        $basket = Basket::getInstance(false);
        echo $basket->getItemsCount();
        break;
    case 'samples':
        $sname=$data['sname'];
        $userBasket=Basket::getItems($USER_ID);
        $id = Samples::checkSample($sname);
        if ($id == false) echo "Error";
        else {
            foreach ($userBasket as $arItems) {
                $sampleItem = array(
                    "ROOT" => $id,
                    "PRODUCT_ID" => $arItems["PRODUCT_ID"],
                    "S_NAME" => $sname,
                    "ART" => $arItems["ART"],
                    "NAME" => $arItems["NAME"],
                    "QUANTITY" => $arItems["QUANTITY"],
                    "USER_ID" => $USER_ID
                );
                $result = Samples::addItemByProduct($sampleItem);
            }
        }
        break;
    case 'samples_show':
        $samplesList=Samples::getGroupItems($USER_ID);
        Template::includeTemplate('samples_items', $samplesList);
        break;
    case 'samples_detail':
        $root = $data['id'];
        $sname = $data['sname'];
        $sampleDetail["ID"] = $root;
        $sampleDetail["NAME"]=$sname;
        $sampleDetail["ITEMS"]=Samples::getSampleDetailItems($USER_ID,$root);
        Template::includeTemplate('samples_detail', $sampleDetail);
        break;
    case 'samples_del':
        $id=$data['id'];
        $sampleItems=Samples::getSampleDetailItems($USER_ID,$id);
        Samples::delete($id);
        foreach($sampleItems as $arItems){
            Samples::delete($arItems["ID"]);
        }
        break;
    case 'sampel_repeate':
        $id=$data['id'];
        $sampleItems=Samples::getSampleDetailItems($USER_ID,$id);
        foreach($sampleItems as $arItems){
            $product = array(
                "PRODUCT_ID" => $arItems["PRODUCT_ID"],
                "ART" => $arItems["ART"],
                "NAME" => $arItems["NAME"],
                "PRICE" => "",
                "QUANTITY" => $arItems["QUANTITY"],
                'USER_ID' => $USER_ID,
            );
            $item = Basket::addItemByProduct($product);
        }
        $basket = Basket::getInstance(false);
        Template::includeTemplate('basket_items', $basket);
        break;
}