<?php

namespace Core\Main;

use Core\Main\DataManager;

class Payment extends DataManager {

    const NAME = 'Documents';
    const ITEMS = 'strings';
    const ONE_ELEMENT = 'name';

    protected $printString = 'print';

    public function getResult($function_name, $arguments, $is_array = false) {
        if (!$this->soap)
            return false;

        $result = $this->soap->call($function_name, $arguments, $is_array);
        $arResult = $result;
        if (stripos($function_name, $this->printString) === false && is_array($result)) {
            $arResult = $this->checkElement($result);
        }

        return $arResult;
    }
    public function checkPDF($doc,$filename) {
        $name = $_SERVER['DOCUMENT_ROOT'] . '/docs/'.$filename.'.pdf';
        $file = iconv('utf-8', 'windows-1251', $name);
        file_put_contents($file, $doc["objectBinary"]);
        $path = '/docs/'.$filename.'.pdf';
        return $path;
    }

    public static function checkElement($result) {
        if (array_key_exists(static::NAME, $result)) {
            return $result;
        } elseif (array_key_exists(static::ONE_ELEMENT, isset($result[static::ITEMS]) ? $result[static::ITEMS] : array())) {
            $arOneElement[] = $result[static::ITEMS];
            $result[static::ITEMS] = $arOneElement;
            return $result;
        } else
            return $result;
    }

}
