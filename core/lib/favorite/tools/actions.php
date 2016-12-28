<?php

include $_SERVER['DOCUMENT_ROOT'] . '/core/loader/prolog_before.php';

use Core\Main\User,
    Core\Main\Favorite,
    Core\Main\Template;

$data = $_POST;
$USER_ID = User::getID();
$product = array(
    "PRODUCT_ID" => $data['id'],
    "ART" => $data['art'],
    "NAME" => $data['name'],
    "PRICE" => $data['price'],
    "QUANTITY" => $data['quantity'],
    "USER_ID" => $USER_ID,
    "TYPE" => "1",
);
switch ($data['TYPE']) {
    case 'add':
        $result = Favorite::addItemByProduct($product);
        echo $result;
        break;
    case 'delete':
        Favorite::delete($data["id"]);
        break;
    case 'list':
        $favorite=Favorite::getInstance(false);
        $result=$favorite->getFavotiteItems();
        Template::includeTemplate('favorit_table', $result);
        break;
}