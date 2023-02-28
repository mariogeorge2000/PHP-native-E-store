<?php

namespace PHPMVC\controllers;

use PHPMVC\Lib\Helper;
use PHPMVC\Lib\InputFilter;
use PHPMVC\models\PrivilegeModel;

class PrivilegesController extends AbstractController
{
    use InputFilter;
    use Helper;

    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->language->load('privileges.default');
        $this->_data['privileges'] = PrivilegeModel::getAll();

        $this->_view();
    }

    public function createAction()
    {
        $this->language->load('template.common');
        $this->language->load('privileges.labels');
        $this->language->load('privileges.create');

        if (isset($_POST['submit'])) {
            $privilege = new PrivilegeModel();
            $privilege->PrivilegeTitle = $this->filterString($_POST['PrivilegeTitle']);
            $privilege->Privilege = $this->filterString($_POST['Privilege']);
            if ($privilege->save()) {
                $this->messenger->add('تم حفظ الصلاحية بنجاح');
                $this->redirect('/privileges');
            }
        }
        $this->_view();
    }

    public function editAction()
    {
        $id = $this->filterInt($this->_params[0]);
        $privilege = PrivilegeModel::getByPK();
        if ($privilege === false) //checking law id mawgood bgd wala la2 abl ma n load el template w el language
        {
            $this->redirect('/privileges');
        }
        $this->_data['privilege'] = $privilege;

        $this->language->load('template.common');
        $this->language->load('privileges.labels');
        $this->language->load('privileges.create');


        if (isset($_POST['submit'])) {
            $privilege->PrivilegeTitle = $this->filterString($_POST['PrivilegeTitle']);
            $privilege->Privilege = $this->filterString($_POST['Privilege']);
            if ($privilege->save()) {
                $this->redirect('/privileges');
            }
        }
        $this->_view();
    }

    public function deleteAction()
    {
        $id = $this->filterInt($this->_params[0]);
        $privilege = PrivilegeModel::getByPK();
        if ($privilege === false) //checking law id mawgood bgd wala la2 abl ma n load el template w el language
        {
            $this->redirect('/privileges');
        }

        if ($privilege->delete()) {
            $this->redirect('/privileges');
        }

    }


}
