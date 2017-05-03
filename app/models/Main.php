<?php

namespace app\models;

class Main extends \vendor\core\Model
{


    public function getDepsToEmployees()
    {
        $sql =
            'SELECT 
                      e.id, 
                      d.id AS department_id, 
                      d.name AS department_name,
                      CONCAT_WS(" ", e.firstname, e.lastname, e.patronymic) AS name
                FROM  departments d 
                      LEFT JOIN employee_department ed ON d.id = ed.id_department
                      LEFT JOIN employee e             ON e.id = ed.id_employee
                ORDER BY e.id';
        
        $rows = $this->pdo->executeWithParams($sql);

        $departments = [];
        $employees = [];
        foreach ($rows as $row) {
            if (!isset($departments[$row['department_id']])) {
                $departments[$row['department_id']] = $row['department_name'];
            }
            if (!isset($employees[$row['id']]) && isset($row['id'])) {
                $employees[$row['id']] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'departments' => []
                ];
            }
            if (!empty($row['name'])) {
                array_push($employees[$row['id']]['departments'], $row['department_id']);
            }
        }
        
        return compact('departments', 'employees');
    }

}