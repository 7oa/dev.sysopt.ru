<?php

namespace Core\Main;

use Core\Main\DataBase;

Class DbSession {

    protected static function isOldSessionIdExist($id) {
        if (!self::isValidId($id))
            return false;
    }

    public static function open($savePath, $sessionName) {
        return true;
    }

    public static function close() {
        DataBase::closeConnet();
    }

    public static function read($id) {
        if (!self::isValidId($id))
            return "";

        $rs = DataBase::getConnection()->query("select SESSION_DATA from session where SESSION_ID = '" . $id . "'");
        if ($rs->rowsCount() > 0) {
            $ar = $rs->fetchRaw();
            $res = base64_decode($ar["SESSION_DATA"]);
            return $res;
        }
        return "";
    }

    public static function write($id, $sessionData) {

        if (!self::isValidId($id))
            return false;

        DataBase::getConnection()->query("insert into session (SESSION_ID, TIMESTAMP_X, SESSION_DATA) values ('" . $id . "', now() , '" . base64_encode($sessionData) . "')");
    }

    public static function destroy($id) {
        if (!self::isValidId($id))
            return false;
        DataBase::getConnection()->query("delete from session where SESSION_ID = '" . $id . "'");
        return true;
    }

    /**
     * Garbage Collector
     * @param 
     */
    public static function gc($maxLifeTime) {
        DataBase::getConnection()->query("delete from session  where TIMESTAMP_X < " . DataBase::SecondsAgo($maxLifeTime));
        return true;
    }

    /**
     * @param string $pId
     * @return bool
     */
    protected static function isValidId($pId) {
        return (bool) preg_match("/^[\\da-z]{6,32}$/iD", $pId);
    }

    protected static function getUserSessID() {
        return session_id();
    }

    public static function initHandlers() {
        if (session_set_save_handler(
                        array('\Core\Main\DbSession', "open"), 
                        array('\Core\Main\DbSession', "close"), 
                        array('\Core\Main\DbSession', "read"), 
                        array('\Core\Main\DbSession', "write"), 
                        array('\Core\Main\DbSession', "destroy"), 
                        array('\Core\Main\DbSession', "gc")
                )) {
            register_shutdown_function("session_write_close");
        }
    }

}
