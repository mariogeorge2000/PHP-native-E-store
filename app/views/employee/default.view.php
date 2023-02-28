<table class="data">
    <thead>
    <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Address</th>
        <th>Salary</th>
        <th>Tax</th>
        <th>Control</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(false !== $employees) {
        foreach ($employees as $employee) {
            ?>
            <tr>
                 <td><?= $employee->name ?></td>
                <td><?= $employee->age ?></td>
                <td><?= $employee->address ?></td>
                <td><?= $employee->salary ?></td>
                <td><?= $employee->tax ?></td>
                <td>
                    <a href="/employee/edit/<?= $employee->id ?>">edit</a>
                    <a href="/employee/delete/<?= $employee->id ?>" onclick="if(!confirm('<?= $text_delete_confirm ?>')) return false;">delete</a>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>