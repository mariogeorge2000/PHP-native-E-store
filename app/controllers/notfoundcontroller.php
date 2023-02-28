<?php

namespace PHPMVC\controllers;

Class NotFoundController extends AbstractController
{
     public function notfoundAction()
     {
         $this->language->load('template.common');
       //  $this->language->load('index.default');
         $this->_view();
     }
}