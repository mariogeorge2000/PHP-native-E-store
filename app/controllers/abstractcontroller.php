<?php

namespace PHPMVC\controllers;

use PHPMVC\Lib\FrontController;
use PHPMVC\lib\Template;
use PHPMVC\lib\Validate;


class AbstractController
{
    use Validate; //2olna use hna msh f ba2i el controllers 3ashan kol el controllers inherit mn el abstract class da so e7na kda msh m7tageen n3ml use Validate f ay controller tani

    protected $_controller;
    protected $_action;
    protected $_params;
    /**
     * @var Template\Template
     */
    protected $_template;
    protected $_registry;


    protected $_data = []; //kol data gdeda 3ayez a3mlha pass lel view..ha7otaha hna

    public function __get($key)
    {
        return $this->_registry->$key; //3ashan lma a3oz a access 3ala el session msln  a call el method de
    }


    public function notFoundAction()
    {
        $this->_view();
    }

    public function setController($controllerName)
    {
        $this->_controller = $controllerName;
    }

    public function setAction($actionName)
    {
        $this->_action = $actionName;
    }

    public function setParams($params)
    {
        $this->_params = $params;
    }

    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    public function setRegistry($registry)
    {
        $this->_registry = $registry;
    }

    public function _view()
    {

        $view = VIEWS_PATH . DS . $this->_controller . DS . $this->_action . '.view.php';
        if ($this->_action == FrontController::NOT_FOUND_ACTION || !file_exists($view)) {
            $view = VIEWS_PATH . DS . 'notfound' . DS . 'default.view.php';
        }
            $this->_data = array_merge($this->_data, $this->language->getDictionary());
            $this->_template->setRegistry($this->_registry);
            $this->_template->setActionViewFile($view);
            $this->_template->setAppData($this->_data);
            $this->_template->renderApp();

    }
}