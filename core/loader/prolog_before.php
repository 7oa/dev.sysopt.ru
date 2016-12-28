<?php

include_once(dirname(__FILE__) . "/../lib/main/loader.php");
use Core\Main\DataBase;

$config = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/config.ini");

\Core\Main\Loader::autoRegisterClasses(
        array(
            "core\\main\\database" => "lib/db/database.php",
            "core\\main\\query" => "lib/db/query.php",
            "core\\main\\dbsession" => "lib/security/dbsession.php",
            "core\\main\\csoapclient" => "main/csoapclient.class.php",
            "core\\main\\cget" => "main/cget.class.php",
            "core\\main\\soap" => "lib/main/soap.php",
            "core\\main\\datamanager" => "lib/main/datamanager.php",
            "core\\main\\catalog" => "lib/catalog/catalog.php",
            "core\\main\\user" => "lib/main/user.php",
			"core\\main\\visits" => "lib/user/visits.php",
            "core\\main\\basket" => "lib/basket/basket.php",
            "core\\main\\order" => "lib/order/order.php",
            "core\\main\\orderstatus" => "lib/order/orderstatus.php",
            "core\\main\\payment" => "lib/order/payment.php",
            "core\\main\\samples" => "lib/basket/samples.php",
            "core\\main\\template" => "lib/main/template.php",
            "core\\main\\favorite" => "lib/favorite/favorite.php",
        )
);

DataBase::connect();

$GLOBALS['DB'] = new DataBase();

define('TEMPLATE_PATH', '/core/templates/main');

require_once(dirname(__FILE__) . "/../loader/init.php");
