Pamoka: <?= $schedule['title'] ?><br/>
Kabinetas: <?= $schedule['cabinet'] ?><br/>
Klasė: <?= $teacher['title'] ?><br/>

<hr>

Mokiniai:<br/>
<table>
    <? foreach ($students as $student) { ?>
        <tr>
            <td><?= $student['firstname'] ?></td>
            <td><?= $student['lastname'] ?></td>
            <td>
                <input type="text"/>
            </td>
            <td>
                <input type="submit" value="Prideti"/>
            </td>
        </tr>
    <? } ?>
</table>
