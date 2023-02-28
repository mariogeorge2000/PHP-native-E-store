<?php

namespace PHPMVC\Lib;

use PHPMVC\lib\registry;
use PHPMVC\Lib\template\Template;

class FrontController
{
    use Helper;

    const NOT_FOUND_ACTION='notFoundAction';
    const NOT_FOUND_CONTROLLER='PHPMVC\controllers\NotFoundController';

    private $_controller='index';
    private $_action='default';
    private $_params=array();

    private $_template;
    private $_registry;
    private $_authentication;

    public function __construct(Template $template, Registry $registry, Authentication $auth)
    {
        $this->_template=$template;
        $this->_registry=$registry;
        $this->_authentication=$auth;
        $this->_parseurl();
    }
   
    private function _parseurl()
    {

        $url = explode('/',trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),'/'),3); //bngeeb details el url
            
        if (isset($url[0]) && $url[0] !='') {
            $this->_controller=$url[0];
        }
        if (isset($url[1]) && $url[1] !='') {
            $this->_action=$url[1];
        }
        if (isset($url[2]) && $url[2] !='') {
            $this->_params=explode('/',$url[2]) ;
        }

        //list($this->_controller, $this->_action, $this->_params) = explode('/', trim($url, '/'), 3); //bn2smo l controllers w ....
        //$this->_params = explode('/', $this->_params);
       // echo '<pre>'; var_dump($this); echo '</pre>';
        
    }

    public function dispatch()
    {
        $controllerClassName='PHPMVC\controllers\\'.ucfirst($this->_controller).'Controller';
        $actionName=$this->_action.'Action';

        //check if the user is authorized to access the application
        if (!$this->_authentication->isAuthorized())
        {
            if ($this->_controller !='auth' && $this->_action !='login'){
                $this->redirect('/auth/login');
            }
        } else{
            if ($this->_controller =='auth' && $this->_action =='login'){ //3ashan law el el user logged in...my2drsh y5rog lel login form 8er lma ydos logout
               isset($_SERVER['HTTP_REFERER']) ? $this->redirect($_SERVER['HTTP_REFERER']) : $this->redirect('/');
            }
            // check if the user has access to specific url
            if( (bool) CHECK_FOR_PRIVILEGES=== true){ //checking for privileges is disabled for now law 3ayzeen nsh8lha yb2a n5li el value bta3t CHECK_FOR_PRIVILEGES=1 fel config file
                if(!$this->_authentication->hasAccess($this->_controller ,$this->_action )){
                    $this->redirect('/accessdenied');
                }
            }
        }

        //check if

        if (!class_exists($controllerClassName) || !method_exists($controllerClassName,$actionName)) {
            $controllerClassName=self::NOT_FOUND_CONTROLLER;
            $this->_action= $actionName=self::NOT_FOUND_ACTION;
        }

        $controller=new $controllerClassName();
        $controller->setController($this->_controller);
        $controller->setAction($this->_action);
        $controller->setParams($this->_params);
        $controller->setTemplate($this->_template);
        $controller->setRegistry($this->_registry);
        $controller->$actionName();
    }
}
