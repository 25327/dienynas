<h1>Pamokos</h1>

<ul>
    <li>
        <a href="<?= base_url('/director') ?>">Pradžia</a>
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
<form action="<?= base_url('/director/createLesson') ?>" method="post">
    <fieldset>
        <legend>Pridėti pamoką:</legend>
        Pamoka: <input type="text" name="title"><br>
        <input type="submit" value="Sukurti">
    </fieldset>
</form>

<hr>

<table>
    <tr>
        <th>ID</th>
        <th>Pavadinimas</th>
    </tr>
    <? foreach ($lessons as $lesson) { ?>
        <tr>
            <td><?= $lesson['id'] ?></td>
            <td><?= $lesson['title'] ?></td>
        </tr>
    <? } ?>
</table>

<hr>

<form action="<?= base_url('/director/updateLesson') ?>" method="post">
    <fieldset>
        <legend>Pridėti pamoką:</legend>
        Pamoka: <input type="text" name="title"><br>
        <input type="submit" value="Sukurti">
    </fieldset>
</form>