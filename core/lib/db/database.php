<?php

namespace Core\Main;

Class DataBase {

    /** @var int */
    protected $affectedRowsCount;
    static $dbType = 'MYSQL';
    static $bConnected;
    private static $dbConn;
    protected $result = null;

    function __construct() {
        if (!static::$bConnected)
            static::doConnet();
    }

    public static function connect() {
        self::doConnet();
    }

    public static function closeConnet() {
        if (self::$bConnected && self::$dbConn) {
            mysql_close(self::$dbConn);
            self::$bConnected = false;
        }
    }

    private static function doConnet() {
        if (self::$bConnected)
            return true;

        $dbName = $GLOBALS['config']['dbName'];
        $dbHost = $GLOBALS['config']['dbHost'];
        $dbLogin = $GLOBALS['config']['dbLogin'];
        $dbPassword = $GLOBALS['config']['dbPassword'];

        self::$dbConn = @mysql_connect($dbHost, $dbLogin, $dbPassword, true);

        if (!@mysql_select_db($dbName, self::$dbConn))
            return false;

        self::$bConnected = true;
    }

    static function secondsAgo($sec) {
        return "DATE_ADD(now(), INTERVAL - " . intval($sec) . " SECOND)";
    }

    public static function getConnection() {
        return new static();
    }

    public function query($strSql) {
        $result = @mysql_query($strSql, static::$dbConn);
        $this->result = $result;
        return $this;
    }

    public function fetchRaw() {
        $result = $this->fetchRowInternal();

        if (!$result) {
            return false;
        }
        return $result;
    }

    public function fetchAll() {
        while ($ar = $this->fetchRaw()) {
            $result[] = $ar;
        }
        return $result;
    }

    public function fetch() {
        $result[] = $this->fetchRaw();
        return $result;
    }

    public function rowsCount() {
        return mysql_num_rows($this->result);
    }

    public function getInsertedId() {
        return mysql_insert_id(static::$dbConn);
    }

    public function setAffectedRowsCount() {
        $this->affectedRowsCount = mysql_affected_rows(static::$dbConn);
    }

    public function getAffectedRowsCount() {
        return $this->affectedRowsCount;
    }

    protected function fetchRowInternal() {
        return mysql_fetch_assoc($this->result);
    }

}
