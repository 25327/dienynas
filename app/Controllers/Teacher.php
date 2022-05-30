<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LessonModel;
use App\Models\StudentModel;
use App\Models\TeacherModel;
use App\Models\ClassModel;
use App\Models\ScheduleModel;

class Teacher extends BaseController
{
    public function __construct()
    {
        if (session()->user['type'] != 'teacher') {
            dd('galima tik mokytojui');
        }
    }

    public function index(string $date = null)
    {
        $teacher = (new TeacherModel())->where('user_id', session()->user['id'])->first();

        $data = [
            'days' => ScheduleModel::DAYS,
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
            'teacher_schedule' => (new ScheduleModel())->getTeacherLessons($teacher['id'], $date),
        ];

        if ($date != null) {
            $data['date'] = $date;
        }

        if ($teacher['class_id'] != 0) {
            $data['schedule'] = ScheduleModel::getLessons($teacher['class_id']);
            $data['students'] = (new ClassModel())->getStudents($teacher['class_id']);
            $data['class'] = (new ClassModel())->find($teacher['class_id']);
            $data['count_lessons'] = (new ScheduleModel())->where('class_id', $teacher['class_id'])->countAll();
            $data['teachers'] = (new TeacherModel())
                ->select('teachers.id, users.email, users.firstname, users.lastname, lessons.title as lesson')
                ->join('users', 'users.id = teachers.user_id')
                ->join('lessons', 'lessons.id = teachers.lesson_id', 'left')
                ->where('lesson_id !=', 0)
                ->findAll();

        }

        return view('users/teacher/home', $data);
    }

    public function addLesson()
    {
        if ($this->validate([
            'week_day' => 'required|in_list[' . implode(',', ScheduleModel::DAYS) . ']',
            'lesson_number' => 'required|integer|exact_length[1]',
            'teacher_id' => 'required|is_not_unique[teachers.id]',
            'cabinet' => 'required|string|min_length[1]|max_length[30]',
        ])) {
            $schedule = (new ScheduleModel())
                ->where('class_id', (new TeacherModel())->where('user_id', session()->user['id'])->first()['class_id'])
                ->where('week_day', $this->request->getVar('week_day'))
                ->where('lesson_number', $this->request->getVar('lesson_number'))
                ->first();
            if (!$schedule) {
                $user = (new TeacherModel())->where('user_id', session()->user['id'])->first();
                $class_id = $user['class_id'];
                $teacher = (new TeacherModel())->where('id', $this->request->getVar('teacher_id'))->first();

                $schedule_data = [
                    'class_id' => $class_id,
                    'lesson_number' => $this->request->getVar('lesson_number'),
                    'lesson_id' => $teacher['lesson_id'],
                    'teacher_id' => $teacher['id'],
                    'cabinet' => $this->request->getVar('cabinet'),
                    'week_day' => $this->request->getVar('week_day'),
                ];

                (new ScheduleModel)->insert($schedule_data);

                return redirect()->to(base_url('/teacher/index'))->with('success', 'Pamoka sėkmingai pridėta prie tvarkaraščio');
            } else {
                $errors = 'Laikas užimtas';
            }
        } else {
            $errors = $this->validator->listErrors();
        }

        return redirect()->to(base_url('/teacher/index'))->with('errors', $errors);
    }

    public function deleteLesson(int $schedule_id)
    {
        $schedule = (new ScheduleModel())->find($schedule_id);
        if ($schedule) {
            (new ScheduleModel())->delete($schedule_id);

            return redirect()->to(base_url('/teacher/index'))->with('success', 'Pamoka pasalinta');
        } else {
            $errors = 'Klaida';
        }
        return redirect()->to(base_url('/teacher/index'))->with('errors', $errors);
    }

    public function date()
    {
        if ($this->validate([
            'date' => 'required|valid_date[Y-m-d]',
        ])) {
            $date = $this->request->getVar('date');
            return redirect()->to(base_url('/teacher/index/' . $date));
        }
        return redirect()->to(base_url('/teacher/index/'))->with('errors', 'Bloga data');
    }

    public function lesson(int $schedule_id, string $date)
    {
        $teacher = (new TeacherModel())
            ->select('teachers.*, lessons.title')
            ->join('lessons', 'lessons.id = teachers.lesson_id')
            ->where('teachers.user_id', session()->user['id'])
            ->first();
        $schedule = (new ScheduleModel())
            ->select('classes.title, schedules.cabinet, schedules.class_id')
            ->join('classes', 'classes.id = schedules.class_id')
            ->where('schedules.week_day', strtolower(date('l', strtotime($date))))
            ->where('schedules.teacher_id', $teacher['id'])
            ->where('schedules.id', $schedule_id)
            ->first();
        if ($schedule) {
            $students = (new StudentModel())
                ->select('users.firstname, users.lastname')
                ->join('users', 'users.id = students.user_id')
                ->where('students.class_id', $schedule['class_id'])
                ->findAll();

            $data = [
                'schedule' => $schedule,
                'students' => $students,
                'teacher' => $teacher,
            ];

            return view('users/teacher/lesson', $data);
        }

        return redirect()->to(base_url('/teacher/index'))->with('errors', 'Klaida');
    }

    public function logout()
    {
        $this->session->remove('user');

        return redirect()->to(base_url('/'));
    }
}