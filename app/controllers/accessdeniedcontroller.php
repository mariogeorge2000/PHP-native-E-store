<?php

namespace PHPMVC\controllers;

Class AccessDeniedController extends AbstractController
{
     public function defaultAction()
     {
         $this->language->load('template.common');
         $this->_view();
     }
}