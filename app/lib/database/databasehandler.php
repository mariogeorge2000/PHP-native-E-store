<?php

namespace PHPMVC\lib\database;

abstract class DatabaseHandler
{

    const DATABASE_DRIVER_PDO = 1;
    const DATABASE_DRIVER_MYSOLI = 2;

    private function __construct()
    {
    }

    abstract protected static function init();

    abstract protected static function getInstance();

    public static function factory()
    {
        $driver = DATABASE_CONN_DRIVER;
        if ($driver == self::DATABASE_DRIVER_PDO) {
            return PDODatabaseHandler::getInstance();
        } else if ($driver == self::DATABASE_DRIVER_MYSOLI) {
            return MySQLiDATABASEHANDLER::getInstance();
        }


    }
}

