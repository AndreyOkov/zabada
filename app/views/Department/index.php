<h1>Отделы</h1>
<table class="table table-bordered">
    <thead>
    <tr>
        <td>Название отдела</td>
        <td>Количество сотрудников</td>
        <td>Максимальная зарплата</td>
        <td></td>
        <td></td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($departments as $row) : ?>
        <tr>
            <th> <?= $row['department_name'] ?> </th>
            <td> <?= ($row ? $row['employee_count'] : '') ?> </td>
            <td> <?= ($row ? $row['max_salary'] : '') ?> </td>
            <td class="index__table-td">
                <a href='/department/update?id=<?= intval($row['id']) ?>' class="glyphicon glyphicon-edit"></a>
            </td>
            <td class="index__table-td">
                <a href='/department/delete?id=<?= intval($row['id']) ?>' class="glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a class='action' href='/department/create'>Создать</a>