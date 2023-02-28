<?php
namespace PHPMVC\lib\database;

use PDO;
use PDOException;

class PDODatabaseHandler extends DatabaseHandler
{
    private static $_instance;
    private static $_handler;

    //singelton
    private function __construct()
    {
        self::init();
    }

    public function __cat($name, $arguments)
    {
        return call_user_func_array(array(&self::$_handler, $name), $arguments);
    }

    protected static function init()
    {

        //liskov substitution

        //try {
        self::$_handler = new \PDO(
            'mysql:hostname=' . DATABASE_HOST_NAME . ';dbname=' . DATABASE_DB_NAME,
            DATABASE_USER_NAME, DATABASE_PASSWORD, array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            )
        );

        //} catch (PDOException $e) {
        //}
    }
    public static function getInstance()
    {

        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_handler;
    }

}
