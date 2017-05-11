<?php
namespace app\models;

use vendor\core\Model;

class Employees extends Model
{
    /**
     * Получаем из базы данных список сотрудников
     * @return array
     */
    public function getEmployees()
    {
        $sql = "SELECT DISTINCT 
                      em.id AS em_id, 
                      CONCAT_WS(' ', em.firstname, em.lastname, em.patronymic) AS fio,
                      em.gender, 
                      em.salary,
                      em.email,
                          (SELECT 
                                GROUP_CONCAT( dp.name ) AS deps
                          FROM 
                               employee em
                               JOIN employee_department emdp   ON em.id = emdp.id_employee
                               JOIN departments dp             ON emdp.id_department = dp.id  
                          WHERE   
                               em.id = em_id) AS departments
                               
                FROM employee em";
        return $this->pdo->executeWithParams($sql);
    }
    public function applyCreateEmployee()
    {
        if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['departments'])) {
            $sql = $this->pdo->executeWithParams('INSERT INTO  employee(firstname, lastname, patronymic, gender, salary,email) VALUES (?, ?, ?, ?, ?, ?)',
                [$_POST['firstname'],
                    $_POST['lastname'],
                    $_POST['patronymic'],
                    $_POST['gender'],
                    $_POST['salary'],
                    $_POST['email']]);
            $employee_id = $this->pdo->getLastId();
            $this->pdo->executeWithParams("DELETE  FROM employee_department WHERE id_employee = ?", [$employee_id]);
            foreach ($_POST['departments'] as $idDepartment) {
                $sql = "INSERT INTO employee_department(id_employee, id_department) VALUES (?, ?)";
                $result = $this->pdo->executeWithParams($sql,[$employee_id,(integer)$idDepartment]);
            }
            return $result;
        }
    }


    public function createEmployee()
    {
        $sql = "SELECT id AS department_id, name AS department_name  FROM departments";
        $result = $this->pdo->executeWithParams($sql,[])->fetchAll();
        return $this->departmentsOfEmployees($result);
    }

    public function updateEmployee($id)
    {

        $sql = "SELECT 
                      e.*, 
                      dp.id AS department_id, 
                      dp.name AS department_name
                FROM departments dp
                LEFT JOIN (
                      SELECT 
                            *
                      FROM 
                            employee_department ed
                      LEFT JOIN employee em     ON ed.id_employee = em.id
                      WHERE em.id =$id) AS e
                ON dp.id = e.id_department";

        $result = $this->pdo->executeWithParams($sql)->fetchAll();
        return $this->departmentsOfEmployees($result);
    }

    public function deleteEmployee($id)
    {
        $this->pdo->executeWithParams("DELETE  FROM employee WHERE id = $id")
        or die("Cannot delete department");

    }

    public function applyUpdateEmployee()
    {
        $id = intval($_POST['id']);
        if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['departments'])) {
            $this->pdo->executeWithParams("DELETE  FROM employee_department WHERE id_employee = ?", [$id]);

            $sql = "UPDATE  employee
                    SET  firstname = ?, lastname = ?, patronymic = ?, gender = ?, salary = ?, email = ? WHERE id= ?";

            $flag = $this->pdo->executeWithParams($sql,
                [$_POST['firstname'],
                    $_POST['lastname'],
                    $_POST['patronymic'],
                    $_POST['gender'],
                    $_POST['salary'],
                    $_POST['email'],
                    $id]);

            // добавляем указанные отделы сотруднику
            foreach ($_POST['departments'] as $idDepartment) {
                $sql = "INSERT INTO employee_department VALUES (?, ?)";
                $result = $this->pdo->executeWithParams($sql,[$id, (integer)$idDepartment]);
            }
            return $result;
        }
    }

    public function departmentsOfEmployees($result){
        $allDepartments = [];
        $employeeDepartments = [];
        foreach ($result as $row) {
            if (!isset($formData)) {
                if (!empty($row['firstname'])) {
                    $formData = $row;
                }
            }
            if (!empty($row['firstname'])) {
                array_push($employeeDepartments, $row['department_name']);
            }
            $allDepartments[$row['department_id']] = $row['department_name'];
        }
        return compact('allDepartments', 'employeeDepartments', 'formData');
    }

}