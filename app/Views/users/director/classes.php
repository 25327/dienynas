<h1>Klases</h1>
<ul>
    <li>
        <a href="<?= base_url('/director') ?>">Pradzia</a>
    </li>
</ul>

<hr>

<? if (isset($errors)) { ?>
    <?= $errors ?>
<? } ?>
<? if (isset($success)) { ?>
    <?= $success ?>
<? } ?>

<hr>

<form action="<?= base_url('/director/createClass') ?>" method="post">
    <fieldset>
        <legend>Pridėti klase:</legend>
        Klase: <input type="text" name="title"><br>
        Maks valandu skaicius per savaite: <input type="number" name="max_week_lessons"><br>
        <input type="submit" value="Sukurti">
    </fieldset>
</form>

<hr>

<? if (isset($class)) { ?>
    <form action="<?= base_url('/director/updateClass/' . $class['id']) ?>" method="post">
        <fieldset>
            <legend>Redaguoti klase:</legend>
            Klase: <input type="text" name="title" value="<?= $class['title'] ?>"><br>
            Maks valandu skaicius per savaite: <input type="number" name="max_week_lessons" value="<?= $class['max_week_lessons'] ?>"><br>
            <input type="submit" value="Atnaujinti">
        </fieldset>
    </form>
<? } ?>

<hr>

<table>
    <tr>
        <th>ID</th>
        <th>Pavadinimas</th>
        <th>Maks. valandu skaicius per savaite</th>
        <th>Veiksmai</th>
    </tr>
    <? foreach ($classes as $class) { ?>
        <tr>
            <td><?= $class['id'] ?> </td>
            <td><?= $class['title'] ?> </td>
            <td><?= $class['max_week_lessons'] ?> </td>
            <td>
                <a href="<?= base_url('/director/classes/' . $class['id']) ?>">Redaguoti</a>
                <a href="<?= base_url('/director/deleteClass/' . $class['id']) ?>">Istrinti</a>
            </td>
        </tr>
    <? } ?>
</table>