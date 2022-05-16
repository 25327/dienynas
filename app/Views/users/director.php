<h1>Direktoriaus aplinka</h1>

<hr>

<? if (isset($errors)) { ?>
    <?= $errors ?>
<? } ?>
<? if (isset($success)) { ?>
    <?= $success ?>
<? } ?>

<hr>

<form action="<?= base_url('/director/createTeacher') ?>" method="post">
    <fieldset>
        <legend>Prideti mokytoja:</legend>
        Email: <input type="text" name="email"><br>
        Slaptazodis: <input type="text" name="password"><br>
        Vardas: <input type="text" name="firstname"><br>
        Pavarde: <input type="text" name="lastname"><br>
        Pamoka: <select name="lesson_id">
            <option value="">-</option>
            <? foreach ($lessons as $lesson) { ?>
                <option value="<?= $lesson['id'] ?>"><?= $lesson['title'] ?></option>
            <? } ?>
        </select><br>
        Klase: <select name="class_id">
            <option value="">-</option>
            <? foreach ($classes as $class) { ?>
                <option value="<?= $class['id'] ?>"><?= $class['title'] ?></option>
            <? } ?>
        </select><br>
        <input type="submit" value="Sukurti">
    </fieldset>
</form>

<hr>

<h1>Mokytojai</h1>
<table>
    <tr>
        <th>ID</th>
        <th>class_id</th>
        <th>lesson_id</th>
    </tr>
    <? foreach ($teachers as $teacher) { ?>
        <tr>
            <td><?= $teacher['id'] ?></td>
            <td><?= $teacher['class_id'] ?></td>
            <td><?= $teacher['lesson_id'] ?></td>
        </tr>
    <? } ?>
</table>

<hr>

<h1>Klases</h1>
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

<hr>

<h1>Pamokos</h1>
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