<?php

namespace Core\Main;

class Soap {

    public $soapObject = null;
    private $soapTypes = array();

    function __construct() {

        $this->soapUrl = $GLOBALS['config']['soapUrl'];
        $this->parameters = array(
            "exceptions" => 1,
            "trace" => 1,
            "login" => $GLOBALS['config']['soapLogin'],
            "password" => $GLOBALS['config']['soapPassword']
            );

        ini_set("soap.wsdl_cache_enabled", "0");
        $this->soapObject = new \SoapClient($this->soapUrl, $this->parameters);
        $this->soapTypes = $this->decodeTypes();
    }

    protected function decodeTypes() {
        $types = $this->soapObject->__getTypes();
        $arTypeArray = array();

        foreach ($types as &$arType):
            $params = array();
            trim($this->decodeType($arType));
            $t = explode('{', $arType);
            $func_name = explode('=>', rtrim($t[0]));
            if (strpos($func_name[1], 'Response'))
                continue;

            $func_params = explode(';', trim($t[1]));
            array_pop($func_params);

            foreach ($func_params as &$value):
                $value = explode('=>', trim($value));
                $params[$value[0]] = $value[1];
            endforeach;
            $arTypeArray[$func_name[1]] = $params;
        endforeach;
        unset($arType);
        unset($value);

        return $arTypeArray;
    }

    function call($function_name, $arguments, $is_array = false) {

        //$this->checkFuncTypes($function_name, $arguments);

        $soapResult = $this->soapObject->__soapCall($function_name, array($arguments));
        if ($is_array)
            return (array) $soapResult->return;
        
        return $this->decodeResult($soapResult);
    }

    protected function decodeResult($result) {
        return json_decode(json_encode($result->return), true);
    }

    protected function decodeType(&$result) {
        $result = preg_replace(array('/(\w+) ([a-zA-Z0-9]+)/', '/\n /', '[}]'), array('${1}=>${2}', "\n\t", "\t"), $result);
    }

    protected function checkFuncTypes($function_name, $arguments) {
        foreach ($this->soapTypes[$function_name] as $k => $arType):
            $error = false;
            $field = $arType;
            $type = $k;
            switch ($k) {
                case 'string':
                    if (!is_string($arguments[$arType]))
                        $error = true;
                    break;

                default:
                    break;
            }
            if ($error)
                throw new \Exception(sprintf('Переменная %s не является %s', $field, $type));
        endforeach;
    }

}
