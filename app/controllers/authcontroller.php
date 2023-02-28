<?php

namespace PHPMVC\controllers;

use PHPMVC\Lib\Helper;
use PHPMVC\lib\Messenger;
use PHPMVC\models\UserModel;

class AuthController extends AbstractController
{
use Helper;
    public function loginAction()
    {
        $this->language->load('auth.login');
        $this->_template->swapTemplate(
            [
                ':view' =>':action_view'
            ]);

        if (isset($_POST['login']))
        {
          $isAuthorized= UserModel::authenticate($_POST['ucname'], $_POST['ucpwd'], $this->session);
          if ($isAuthorized==2){
              $this->messenger->add($this->language->get('text_user_disabled', Messenger::APP_MESSAGE_ERROR));
          } elseif ($isAuthorized == 1) {
              $this->redirect('/');
          } elseif ($isAuthorized === false) {
              $this->messenger->add($this->language->get('text_user_not_found'), Messenger::APP_MESSAGE_ERROR);
          }
        }
        $this->_view();
    }

    public function logoutAction()
    {
        $this->session->kill(); //3mlna kill lel session 3ashan elly y5rog my3rfsh y3ml 7aga fel app 8er lma y3ml login tani
        $this->redirect('/auth/login');
    }

}
