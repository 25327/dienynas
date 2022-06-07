<h1>Studento aplinka</h1>

<hr>

Klasė: <?= $class['title'] ?> <br/>
Mokytoja/s: <?= $teacher['firstname'] ?> <?= $teacher['lastname'] ?><br/>

<hr>

<table>
    <tr>
        <?
        $begin = new DateTime("2022-05-30");
        $end = new DateTime("2022-06-03");

        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            ?>
            <th style="min-width: 90px;">
                <?= $i->format("Y-m-d") ?>
            </th>
            <?
        }
        ?>
    </tr>
    <tr>
        <?
        $begin = new DateTime("2022-05-30");
        $end = new DateTime("2022-06-03");

        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            $date = $i->format("Y-m-d");
            $week_day = strtolower(date('l', strtotime($date)));
            $lessons = \App\Models\ScheduleModel::getLessonsByWeekDay($week_day, $class['id']);
            ?>
            <td>
                <table>
                    <?
                    foreach ($lessons as $lesson) {
                        $grade = (new \App\Models\GradeModel())->getStudentGrade($student['id'], $date, $lesson['lesson_id']);
                        //notice
                        //lankomumas
                        ?>
                        <tr>
                            <td>
                                <?= $lesson['lesson_number'] ?>
                            </td>
                            <td>
                                <?= $lesson['title'] ?>
                            </td>
                            <td>
                                <?= $grade ?>

                            </td>
                        </tr>
                    <? } ?>
                </table>
            </td>
        <? } ?>
    </tr>
</table>