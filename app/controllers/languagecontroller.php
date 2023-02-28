<?php

namespace PHPMVC\Controllers;

use PHPMVC\lib\Helper;

class languagecontroller extends AbstractController
{
    use Helper;
    public function DefaultAction()
    {
        if($_SESSION['lang'] =='ar' ){
            $_SESSION['lang']='en';
        }else{
            $_SESSION['lang']='ar';
        }

        $this->redirect($_SERVER['HTTP_REFERER']);
    }

}