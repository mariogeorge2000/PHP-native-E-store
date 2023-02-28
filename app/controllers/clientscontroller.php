<?php

namespace PHPMVC\controllers;

use http\Client\Curl\User;
use PHPMVC\Lib\Helper;
use PHPMVC\Lib\InputFilter;
use PHPMVC\Models\ClientModel;

class ClientsController extends AbstractController
{
    use InputFilter;
    use Helper;

    private $_createActionRoles =
        [
            'Name'              => 'req|alpha|between(2,40)',
            'Email'             => 'req|email',
            'PhoneNumber'       => 'alphanum|max(15)',
            'Address'               => 'req|alphanum|max(50)'
        ];



    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('clients.default');
        $this->_data['clients'] = ClientModel::getAll();

        $this->_view();
    }

    public function createAction()
    {
        $this->language->load('template.common');
        $this->language->load('users.create');
        $this->language->load('users.labels');
        $this->language->load('users.messages');


        if (isset($_POST['submit']) && $this->isValid($this->_createActionRoles, $_POST)) //law mafesh ay error fel form w kol el data tmam sa3etha hy3ml object gded
        {
            $client = new ClientModel();

            $client->Name = $this->filterString($_POST['Name']);
            $client->Email = $this->filterString($_POST['Email']);
            $client->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
            $client->Address = $this->filterString($_POST['Address']);


            if ($client->save()) {
                $this->messenger->add($this->language->get('message_create_success'));
            } else {
                $this->messenger->add($this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/clients');
        }

        $this->_view();

    }

    public function editAction()
    {
        $id = $this->_params[0]; //el id y3ny
        $client = ClientModel::getByPK($id);

        if($client === false) {
            $this->redirect('/clients');
        }

        $this->_data['client'] = $client;

        $this->language->load('template.common');
        $this->language->load('clients.edit');
        $this->language->load('clients.labels');
        $this->language->load('clients.messages');
        $this->language->load('validation.errors');


        if (isset($_POST['submit']) && $this->isValid($this->_createActionRoles, $_POST)) //law mafesh ay error fel form w kol el data tmam sa3etha hy3ml object gded
        {
            $client->Name = $this->filterString($_POST['Name']);
            $client->Email = $this->filterString($_POST['Email']);
            $client->PhoneNumber = $this->filterString($_POST['PhoneNumber']);
            $client->Address = $this->filterString($_POST['Address']);



            if ($client->save()) {
                $this->messenger->add($this->language->get('message_create_success'));
            } else {
                $this->messenger->add($this->language->get('message_create_failed'), Messenger::APP_MESSAGE_ERROR);
            }
            $this->redirect('/clients');
        }

        $this->_view();

    }

    public function deleteAction()
    {
        $id = $this->filterInt($this->_params[0]);
        $client = ClientModel::getByPK($id);

        if($client === false) {
            $this->redirect('/clients');
        }

        $this->language->load('clients.messages');

        if($client->delete()) {
            $this->messenger->add($this->language->get('message_delete_success'));
        } else {
            $this->messenger->add($this->language->get('message_delete_failed'), Messenger::APP_MESSAGE_ERROR);
        }
        $this->redirect('/clients');
    }


}
