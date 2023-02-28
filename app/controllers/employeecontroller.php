<?php

namespace PHPMVC\controllers;

use PHPMVC\Lib\Helper;
use PHPMVC\Lib\InputFilter;
use PHPMVC\models\EmployeeModel;

class EmployeeController extends AbstractController
{
    use InputFilter; //trait used to filter the inputs

    use Helper;

    public function defaultAction()
    {
        $this->_language->load('template.common');
        $this->_language->load('employee.default');
        $this->_data['employees'] = EmployeeModel::getAll();
        $this->_view();
    }

    public function addAction()
    {
        if (isset($_POST['submit'])) {
            $emp = new EmployeeModel();
            $emp->name = $this->filterString($_POST['name']);
            $emp->age = $this->filterInt($_POST['age']);
            $emp->address = $this->filterString($_POST['address']);
            $emp->salary = $this->filterInt($_POST['salary']);
            $emp->tax = $this->filterInt($_POST['tax']);
            if ($emp->save()) {
                $_SESSION['message'] = 'employee, saved successfully';
                $this->redirect('/employee');
            }
        }
        $this->_view();
    }

    public function editAction()
    {
        $id = $this->filterInt($this->_params[0]);
        $emp = EmployeeModel::getByPK($id);
        if ($emp === false) {
            $this->redirect('/employee');
        }
        $this->_data['employee'] = $emp;

        if (isset($_POST['submit'])) {
            $emp->name = $this->filterString($_POST['name']);
            $emp->age = $this->filterInt($_POST['age']);
            $emp->address = $this->filterString($_POST['address']);
            $emp->salary = $this->filterFloat($_POST['salary']);
            $emp->tax = $this->filterFloat($_POST['tax']);
            if ($emp->save()) {
                $_SESSION['message'] = 'employee, saved successfully';
                $this->redirect('/employee');
            }
        }
        $this->_view();
    }

    public function deleteAction()
    {
        $id = $this->filterInt($this->_params[0]);
        $emp = EmployeeModel::getByPK($id);
        if ($emp === false) {
            $this->redirect('/employee');
        }
        if ($emp->delete()) {
            $_SESSION['message'] = 'employee, deleted successfully';
            $this->redirect('/employee');
        }
    }
}