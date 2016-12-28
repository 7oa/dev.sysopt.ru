<?

namespace Core\Main;

final class Loader {

    private static $isAutoLoadOn = true;
    private static $arAutoLoadClasses = array();

    const ALPHA_LOWER = "qwertyuioplkjhgfdsazxcvbnm";
    const ALPHA_UPPER = "QWERTYUIOPLKJHGFDSAZXCVBNM";

    public static function getDocumentRoot() {
        static $documentRoot = null;
        if ($documentRoot === null)
            $documentRoot = rtrim($_SERVER["DOCUMENT_ROOT"], "/\\");
        return $documentRoot;
    }

    public static function autoLoad($className) {

        $file = ltrim($className, "\\");
        $file = strtr($file, static::ALPHA_UPPER, static::ALPHA_LOWER);
        
        static $documentRoot = null;
        if ($documentRoot === null)
            $documentRoot = static::getDocumentRoot();
                    
        if (isset(self::$arAutoLoadClasses[$file])) {
            $pathInfo = self::$arAutoLoadClasses[$file];
            include_once($documentRoot . "/core/" . $pathInfo["file"]);
            return;
        }

        if (preg_match("#[^\\\\/a-zA-Z0-9_]#", $file))
            return;

        if (substr($file, -5) == "table")
            $file = substr($file, 0, -5);

        $file = str_replace('\\', '/', $file);
        $arFile = explode("/", $file);
    }

    public static function switchAutoLoad($value = true) {
        static::$isAutoLoadOn = $value;
    }

    public static function autoRegisterClasses(array $arClasses) {

        if (empty($arClasses))
            return;

        foreach ($arClasses as $key => $value) {
            $class = ltrim($key, "\\");
            self::$arAutoLoadClasses[strtr($class, static::ALPHA_UPPER, static::ALPHA_LOWER)] = array("file" => $value);
        }
       
    }

}

if (!function_exists("__autoload")) {
    if (function_exists('spl_autoload_register')) {
        \spl_autoload_register('\Core\Main\Loader::autoLoad');
    } else {

        function __autoload($className) {
            Loader::autoLoad($className);
        }
    }
    Loader::switchAutoLoad(true);
} else {
    Loader::switchAutoLoad(false);
}