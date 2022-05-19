<h1>Mokytojo aplinka</h1>

<hr>

<? if (isset($class)) { ?>
    Mano klasė: <?= $class['title'] ?>
    <hr>
    <table>
        <tr>
            <th>ID</th>
            <th>el. paštas</th>
            <th>Vardas</th>
            <th>Pavardė</th>
        </tr>
        <? foreach ($students as $student) { ?>
            <tr>
                <td><?= $student['id'] ?></td>
                <td><?= $student['email'] ?? null ?></td>
                <td><?= $student['firstname'] ?? null ?></td>
                <td><?= $student['lastname'] ?? null ?></td>
            </tr>
        <? } ?>
    </table>
<? } ?>