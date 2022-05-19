<h1>Klases</h1>
<ul>
    <li>
        <a href="<?= base_url('/director') ?>">Pradzia</a>
    </li>
</ul>

<hr>

<table>
    <tr>
        <th>ID</th>
        <th>Pavadinimas</th>
    </tr>
    <? foreach ($classes as $class) { ?>
        <tr>
            <td><?= $class['id'] ?> </td>
            <td><?= $class['title'] ?> </td>
        </tr>
    <? } ?>
</table>