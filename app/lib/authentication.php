<?php

namespace PHPMVC\Lib;

class Authentication //class for checking if the user is logged in or not and the privileges he has
{
    private static $_instance;
    private $_session;
    private $_execludedRoutes = [
        '/index/default',
        '/auth/logout',
        '/users/profile',
        '/users/changepassword',
        '/users/settings',
        '/language/default',
        '/accessdenied/default',
        '/notfound/notfound',
        '/test/default'
    ];

    private function __construct($session)
    {
        $this->_session=$session; //hn3ml pass lel session f getInstance 3ashan el session tb2a m3ana
    }

    private function __clone()
    {

    }

    public static function getInstance(SessionManager $session)
    {
        if (self::$_instance === null) {
            self::$_instance = new self($session);
        }
        return self::$_instance;
    }

    public function isAuthorized()
    {
       return isset($this->_session->u);
    }

    //checking if the user has access to that url or nor (controller/action)
    public function hasAccess($controller, $action)
    {
        $url = '/' . $controller . '/' . $action ;
        if(in_array($url, $this->_execludedRoutes) || in_array($url, $this->_session->u->privileges)) {
            return true;
        }
    }
}