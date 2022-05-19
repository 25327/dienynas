<h1>Mokiniai</h1>

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

<form action="<?= base_url('/director/createStudent') ?>" method="post">
    <fieldset>
        <legend>Prideti mokini:</legend>
        Email: <input type="text" name="email"><br>
        Slaptazodis: <input type="text" name="password"><br>
        Vardas: <input type="text" name="firstname"><br>
        Pavarde: <input type="text" name="lastname"><br>
        Klase: <select name="class_id">
            <option value="">-</option>
            <? foreach ($classes as $class) { ?>
                <option value="<?= $class['id'] ?>"><?= $class['title'] ?></option>
            <? } ?>
        </select><br>
        <input type="submit" value="Sukurti">
    </fieldset>
</form>


<? if (isset($student)) { ?>
    <form action="<?= base_url('/director/updateStudent/' . $student['id']) ?>" method="post">
        <fieldset>
            <legend>Redaguoti moksleivį:</legend>
            Email: <input type="text" name="email" value="<?= $student['email'] ?>"><br>
            Slaptažodis: <input type="text" name="password"><br>
            Vardas: <input type="text" name="firstname" value="<?= $student['firstname'] ?>"><br>
            Pavardė: <input type="text" name="lastname" value="<?= $student['lastname'] ?>"><br>
            Klasė: <select name="class_id">
                <option value="">-</option>
                <? foreach ($classes as $class) { ?>
                    <option value="<?= $class['id'] ?>" <? if ($student['class_id'] == $class['id']) {
                        echo 'selected';
                    } ?> ><?= $class['title'] ?></option>
                <? } ?>
            </select><br/>
            <input type="submit" value="Išsaugoti">
        </fieldset>
    </form>
    <hr>
<? } ?>

<hr>

<table>
    <tr>
        <th>ID</th>
        <th>El. pastas</th>
        <th>Vardas</th>
        <th>Pavarde</th>
        <th>Klase</th>
        <th>Veiksmas</th>
    </tr>
    <? foreach ($students as $student) { ?>
        <tr>
            <td><?= $student['id'] ?></td>
            <td><?= $student['email'] ?></td>
            <td><?= $student['firstname'] ?></td>
            <td><?= $student['lastname'] ?></td>
            <td><?= $student['class'] ?></td>
            <td>
                <a href="<?= base_url('/director/students/' . $student['id']) ?>">Redaguoti</a>
                <a href="<?= base_url('/director/deleteStudent/' . $student['id']) ?>">Istrinti</a>
            </td>
        </tr>

    <? } ?>
</table>