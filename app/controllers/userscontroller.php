<?php

namespace PHPMVC\controllers;

use http\Client\Curl\User;
use PHPMVC\Lib\Helper;
use PHPMVC\Lib\InputFilter;
use PHPMVC\models\UserGroupModel;
use PHPMVC\models\usermodel;
use PHPMVC\models\UserProfileModel;

class UsersController extends AbstractController
{
    use InputFilter;
    use Helper;

    private $_createActionRoles =
        [
            //bn7ot hna el roles elly 3ayzeen nmshy 3aliha f kol field...w hnst5dm el methods elly f validate trait
            'Firstname' => 'req|alpha|between(3,10)',
            'Lastname' => 'req|alpha|between(3,10)',
            'Username' => 'req|alphanum|between(3,12)',
            'Password' => 'req|min(6)|eq_field(CPassword)',
            'CPassword' => 'req|min(6)',
            'Email' => 'req|email',
            'CEmail' => 'req|email',
            'PhoneNumber' => 'alphanum|max(15)',
            'GroupId' => 'req|int'
        ];

    private $_editActionRoles =
        [
            'PhoneNumber' => 'alphanum|max(15)',
            'GroupId' => 'req|int'
        ];

    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('users.default');
        $this->_data['users'] = UserModel::getUsers($this->session->u); //u da el user elly mtsgl 3andy fel session

        $this->_view();
    }

    public function createAction()
    {
        $this->language->load('template.common');
        $this->language->load('users.create');
        $this->language->load('users.labels');
        $this->language->load('users.messages');
        $this->language->load('validation.errors');

        $this->_data['groups'] = UserGroupModel::getAll();

        if (isset($_POST['submit']) && $this->isValid($this->_createActionRoles, $_POST)) //law mafesh ay error fel form w kol el data tmam sa3etha hy3ml object gded
        {
            $user = new UserModel();
            $user->Username = $this->filterString($_POST['Username']);
            $user->cryptPassword($_POST['Password']);
            $user->email = $this->filterString($_POST['Email']);
            $user->phone_number = $this->filterString($_POST['PhoneNumber']);
            $user->group_id = $this->filterString($_POST['group_id']);
            $user->subscription_date = date('y-m-d');
            $user->last_login = date('y-m-d H:i:s');
            $user->status = 1;

            if (UserModel::userExists($user->Username)) {
                $this->messenger->add($this->language->get('message_user_exists'), Messenger::APP_MESSAGE_ERROR);
                $this->redirect('/users');
            }

            if ($user->save()) {
                $userprofile = new UserProfileModel();
                $userprofile->UserId = $user->UserId;
                $userprofile->first_name = $this->filterString($_POST['first_name']);
                $userprofile->last_name = $this->filterString($_POST['last_name']);
                $userprofile->save(false);
                $this->messenger->add($this->language->get('message_create_success'));
            } else {
                $this->messenger->add($this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/users');
        }

        $this->_view();

    }

    public function editAction()
    {
        $id = $this->_params[0]; //el id y3ny
        $user = UserModel::getByPK($id);

        if ($user === false ||  $this->session->u->UserId ==$id) {
            $this->redirect('/users');
        }
        $this->_data['user'] = $user;

        $this->language->load('template.common');
        $this->language->load('users.edit');
        $this->language->load('users.labels');
        $this->language->load('users.messages');

        $this->_data['groups'] = UserGroupModel::getAll();

        if (isset($_POST['submit']) && $this->isValid($this->_editActionRoles, $_POST)) //law mafesh ay error fel form w kol el data tmam sa3etha hy3ml object gded
        {
            $user->phone_number = $this->filterString($_POST['PhoneNumber']);
            $user->group_id = $this->filterString($_POST['group_id']);


            if ($user->save()) {
                $this->messenger->add($this->language->get('message_create_success'));
            } else {
                $this->messenger->add($this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/users');
        }

        $this->_view();

    }

    public function deleteAction()
    {
        $id = $this->_params[0]; //el id y3ny
        $user = UserModel::getByPK($id);

        if ($user === false ||  $this->session->u->UserId ==$id) {
            $this->redirect('/users');
        }

        $this->language->load('users.messages');

        if ($user->delete()) {
            $this->messenger->add($this->language->get('message_delete_success'));
        } else {
            $this->messenger->add($this->language->get('message_delete_failed'), Messenger::APP_MESSAGE_ERROR);
        }
        $this->redirect('/users');

    }

    public function addAction()
    {
        $this->_view();
    }

}
