<?php

namespace Core\Main;

use Core\Main\DataManager,
    Core\Main\User;

class Order extends DataManager {

    const NAME = 'Orders';
    const ID = 'id';
    const ITEMS = 'strings';

    protected $printString = 'print';
    public $docFolder = 'docs';

    protected function fields1c() {
        return array(
            'user_id' => array('type' => 'Core\Main\User'),
            'date' => array('type' => 'DateTime'),
            'number' => array('type' => 'integer'),
        );
    }

    public function getResult($function_name, $arguments, $is_array = false) {
        if (!$this->soap)
            return false;

        $result = $this->soap->call($function_name, $arguments, $is_array);
        if ($this->checkResultArray($function_name, $result)) {
            $arResult = $this->check($result);
        } else
            $arResult = $result;
        //для статистики посещений - записываем факт совешения заказа
        if ($arResult[0] == "Документ оформлен!") {
            $connection = DataBase::getConnection();
            $user_id = User::getID();
            $connection->query("INSERT INTO `orders` (USER_ID, ORDER_NUM) VALUES ('$user_id','$arResult[1]')");
        }

        return $arResult;
    }
    public function checkPDF($doc,$filename) {
        $filename=$this->translit($filename);
        $name = $_SERVER['DOCUMENT_ROOT'] . '/docs/'.$filename.'.pdf';
        $file = iconv('utf-8', 'windows-1251', $name);
        file_put_contents($file, $doc["objectBinary"]);
        $path = '/docs/'.$filename.'.pdf';
        return $path;
    }

    protected function checkResultArray($function_name, $result) {
        return stripos($function_name, $this->printString) === false && is_array($result) && !empty($result);
    }

    public static function check($result) {
        if (array_key_exists(static::NAME, $result) && array_key_exists(0, $result[static::NAME]))
            return $result[static::NAME];
        if ($result[static::ITEMS]) {
            if (array_key_exists(static::ID, $result[static::ITEMS])) {
                $onItem[] = $result[static::ITEMS];
                $result[static::ITEMS] = $onItem;
                return $result;
            } else
                return $result;
        }
        if ($result[static::NAME]) {
            return $result;
        }
		if (array_key_exists(0, $result["Strings"]))
            return $result["Strings"];
		
    }

    function translit($str) {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
        return str_replace($rus, $lat, $str);
    }

}
