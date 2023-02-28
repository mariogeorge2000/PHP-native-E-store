<?php

namespace PHPMVC\lib;

class Registry
{
    private static $_instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (self::$_instance===null){
            self::$_instance=new self();
        }
        return self::$_instance;
    }

    public function __self($key, $object)
    {
        $this->$key=$object;
    }

    public function __get($key)
    {
        return $this->$key;
    }
}