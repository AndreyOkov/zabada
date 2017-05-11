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

    public function ajaxAction()
    {
        $this->view = '';
        $this->layout = false;
        
        if ( !empty($_POST) ) {
            $values = $_POST["formData"];
            $rules = [
                "email" => "required|isEmail"
            ];
            $result = $this->validate($values, $rules);
            echo json_encode($result);
        } else {
            die('Not found formData');
        }
    }

    private function validate($values, $rules)
    {
        if (is_array($values)) {
            if (!empty($rules)) {
                $errors = [];
                $valid = true;
                foreach ($rules as $formKey => $rule) {
                    $splitRules = explode("|", $rule);
                    $errors[$formKey] = [];
                    foreach ($splitRules as $splitRule) {
                        $splitRuleWithOptions = explode(":", $splitRule);
                        switch ($splitRuleWithOptions[0]) {
                            case 'required':
                                if (!isset($values[$formKey]) ||
                                    empty($values[$formKey]) ||
                                    strlen($values[$formKey]) == 0
                                ) {
                                    $errors[$formKey][] = $formKey . " is required";
                                }
                                break;
                            case 'positive':
                                $values[$formKey] = intval($values[$formKey]);

                                if (!is_int($values[$formKey]) || $values[$formKey] < 0) {
                                    $errors[$formKey][] = $formKey . " must be a number biger than 0";
                                }
                                break;
                            case 'isEmail':
                                if(!filter_var($values[$formKey], FILTER_VALIDATE_EMAIL)){
                                    $errors[$formKey][] = $formKey. " incorrect email";
                                }
                        }
                    }
                }
                foreach ($errors as $key => $error) {
                    if (count($error) > 0) {
                        $valid = false;
                    }
                }
                return [$valid, $errors];
            } else {
                die('Отсутствуют правила валидации');
            }
        } else {
            die('Отсутствует массив с данными');
        }
    }
}