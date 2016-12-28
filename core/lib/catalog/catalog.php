<?php

namespace Core\Main;

use Core\Main\Html;

class Catalog extends DataManager {

    const NAME = 'Products';
    const GROUPS = 'Groups';
    const ONE_ELEMENT = 'id';

    public $emptyText = '<span>У выбранного раздела отсутствуют элементы</span>';

    public function getResult($function_name, $arguments, $is_array = false) {
        if (!$this->soap)
            return false;

        $result = $this->soap->call($function_name, $arguments, $is_array);
        $arResult = $this->checkElement($result);
        return $arResult;
    }

    public function checkDetailImage($product) {
        $filename=$this->translit($product["id"]);
        $img = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $filename . '.' . $product["img_ext"];
        $file = iconv('utf-8', 'windows-1251', $img);
        file_put_contents($file, $product["img"]);
        $path = 'images/' . $filename . '.' . $product["img_ext"];
        return $path;
    }

    public static function checkElement($result) {
        if (array_key_exists(static::NAME, $result) && array_key_exists(0, $result[static::NAME]))
            return $result[static::NAME];
        elseif (array_key_exists(static::GROUPS, $result)){
            if(array_key_exists(static::ONE_ELEMENT, $result[static::GROUPS])){
                $arOneElement[] = $result[static::GROUPS];
                return $arOneElement;
            }
            else
            return $result[static::GROUPS];
        }

        elseif (array_key_exists(static::ONE_ELEMENT, $result)) {
            $arOneElement[] = $result;
            return $arOneElement;
        } else
            return $result;
    }
    function translit($str) {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
        return str_replace($rus, $lat, $str);
    }
}
