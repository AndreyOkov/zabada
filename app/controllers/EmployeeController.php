<?php

namespace app\controllers;

use app\models\Employees;

class EmployeeController extends AppController
{

    public function indexAction()
    {
        $model = new Employees();
        $employees = $model->getEmployees();
        $this->set(compact('employees'));
    }

    public function updateAction($id)
    {
        $this->view = '_form';
        $model = new Employees();
        if (isset($_GET['type'])) {
            if ($_GET['type'] === 'update') {
                $model->applyUpdateEmployee();
            } else {
                $model->applyCreateEmployee();
            }
            $this->redirect('/employee/index');

        } else {
            extract($model->updateEmployee($id));
            $type = 'update';
            $this->set(compact('departments', 'type', 'allDepartments', 'employeeDepartments', 'formData'));
        }
    }

    public function createAction()
    {
        $this->view = '_form';

        $model = new Employees();
        extract($model->createEmployee());
        $type = 'create';
        $this->set(compact('departments', 'type', 'allDepartments', 'employeeDepartments', 'formData'));
    }

    public function deleteAction($id)
    {
        $model = new Employees();
        $model->deleteEmployee($id);
        $this->redirect('/employee/index');
    }


    public function applyCreateEmployeeAction()
    {
        $model = new Employees();
        $res = $model->applyCreateEmployee();

        if ($res) {
            $this->redirect('/employee/index');
        }
    }


}