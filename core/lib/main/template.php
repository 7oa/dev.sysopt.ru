<?php

namespace Core\Main;

class Template {

    protected static $instance = null;

    const TEMPLATE_FOLDER = '/core/site_templates/';
    const FILE_EXT = '.php';

    public static function getInstance() {
        if (!isset(static::$instance))
            static::$instance = new static();

        return static::$instance;
    }

    public static function includeTemplate($file, &$arResult = array()) {

        $file = $_SERVER["DOCUMENT_ROOT"] . static::TEMPLATE_FOLDER . $file . static::FILE_EXT;
        if (file_exists($file)) {
            include($file);
            return null;
        }
    }
    
    public function statusMail() {
        return "Изменился статус заказа № #ORDER_ID# на #VALUE#";
    }

}
