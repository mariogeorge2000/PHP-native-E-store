<?php

namespace PHPMVC\controllers;

class IndexController extends AbstractController
{

    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('index.default');
        $this->_view();
    }

    public function addAction()
    {
       $this->_view(); 
    }

}
