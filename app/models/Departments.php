<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 02.05.2017
 * Time: 20:48
 */

namespace app\models;


use vendor\core\Model;

class Departments extends Model
{
    public function getDepartments(){
        $sql = "SELECT 
                      d.id,
                      d.name department_name,
                      COUNT(e.firstname) employee_count, 
                      MAX(e.salary) max_salary
                FROM 
                      departments d
                      LEFT JOIN employee_department ed  ON d.id = ed.id_department
                      LEFT JOIN employee e 			    ON ed.id_employee = e.id
                GROUP BY d.name";
        return $this->pdo->executeWithParams($sql)->fetchAll();
    }
    public function getById($id){
        return  $this->pdo->executeWithParams("SELECT * FROM departments WHERE id = ?", [$id])->fetch();
    }
    
    public function updateDepartments($id, $name){
        return $this->pdo->executeWithParams("UPDATE `departments` SET name=? WHERE id=?", [$name, $id]);
    }

    public function createDepartments($name){
        $this->pdo->executeWithParams("INSERT INTO departments(name) VALUES( ? )", [$name]);
    }
    public function deleteDepartment($id){
        $this->pdo->executeWithParams("DELETE  FROM `departments` WHERE id = $id");
    }

}