<?php

namespace PHPMVC;

use PHPMVC\Lib\Authentication;
use PHPMVC\Lib\FrontController;
use PHPMVC\Lib\Messenger;
use PHPMVC\Lib\Registry;
use PHPMVC\lib\SessionManager;
use PHPMVC\Lib\Template\Template;
use PHPMVC\lib\Language;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

require_once '..' . DS . 'app' . DS . 'config' . DS . 'config.php';
require_once APP_PATH . DS . 'lib' . DS . 'autoload.php';

$session=new SessionManager();
$session->start();

if (!isset($session->lang))
{
    $session->lang=APP_DEFAULT_LANGUAGE;
}

$template_parts = require_once '..' . DS . 'app' . DS . 'config' . DS . 'templateconfig.php';

$template=new Template($template_parts);

$language=new Language();

$messenger=Messenger::getInstance($session);

$authentication = Authentication::getInstance($session);

$registry=Registry::getInstance();
$registry->session=$session;
$registry->language=$language;
$registry->messenger=$messenger;

$frontcontroller = new FrontController($template, $registry, $authentication);
$frontcontroller->dispatch();

