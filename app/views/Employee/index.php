<h1>Сотрудники</h1>
<table class="table table-bordered">
    <tr>
        <td>ФИО</td>
        <td>Пол</td>
        <td>З/п</td>
        <td>Отдел</td>
        <td>E-mail</td>
        <td></td>
        <td></td>
    </tr>
    <?php foreach ($employees as $row) : ?>
        <tr>
            <td><?= $row['fio'] ?></td>
            <td><?= $row['gender'] ?></td>
            <td><?= $row['salary'] ?></td>
            <td width="300"><?= $row['departments'] ?></td>
            <td><?= $row['email'] ?></td>
            <td class="index__table-td">
                <a href="/employee/update?id=<?= $row['em_id'] ?>" class="glyphicon glyphicon-edit"></a>
            </td>
            <td class="index__table-td">
                <a href="/employee/delete?id=<?= $row['em_id'] ?>" class="glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<a class='action' href='/employee/create?type=create'>СОЗДАТЬ</a>