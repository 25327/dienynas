Pamoka: <?= $schedule['title'] ?><br/>
Kabinetas: <?= $schedule['cabinet'] ?><br/>
Klasė: <?= $teacher['title'] ?><br/>
Data: <?= $date ?><br/>

<hr>

Mokiniai:<br/>
<form action="<?= base_url('/teacher/saveLesson/' . $teacher['id'] . '/' . $teacher['lesson_id'] . '/' . $date) ?>"
      method="post">
    <table>
        <? foreach ($students as $student) { ?>
            <tr>
                <td><?= $student['firstname'] ?></td>
                <td><?= $student['lastname'] ?></td>
                <td>
                    <input name="content[<?= $student['id'] ?>]" type="text"/>
                </td>
            </tr>
        <? } ?>
    </table>
    <input type="submit" value="Prideti"/>
</form>

