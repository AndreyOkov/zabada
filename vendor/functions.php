<?php
function field($model, $fieldname)
{
    return $model[$fieldname] ?: '';
}

function optionHelper($allDepartments, $employeeDepartments = [])
{
    foreach ($allDepartments as $departmentID => $department) {
        $select = isset($employeeDepartments) ?
            (in_array($department, $employeeDepartments) ? 'selected="selected"' : '') : '';
        echo "<option value=\"$departmentID\" $select > $department </option> <br>";
    }
}

