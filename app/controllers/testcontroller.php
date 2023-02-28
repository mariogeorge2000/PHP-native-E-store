<?php

namespace PHPMVC\Controllers;

use PHPMVC\Lib\Validate;
use PHPMVC\Models\UserProfileModel;

class Testcontroller extends AbstractController
{
    use Validate;

    public function defaultAction()
    {
       //testing Validate trait
    }



}