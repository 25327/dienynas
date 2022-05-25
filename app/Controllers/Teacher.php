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

    public function index()
    {
        $teacher = (new TeacherModel())->where('user_id', session()->user['id'])->first();

        $data = [
            'students' => (new ClassModel())->getStudents($teacher['class_id']),
            'days' => ScheduleModel::DAYS,
            'teachers' => (new TeacherModel())
                ->select('teachers.id, users.email, users.firstname, users.lastname, lessons.title as lesson')
                ->join('users', 'users.id = teachers.user_id')
                ->join('lessons', 'lessons.id = teachers.lesson_id', 'left')
                ->where('lesson_id !=', 0)
                ->findAll(),
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
            'schedule' => ScheduleModel::getLessons($teacher['class_id']),
            'count_lessons' => (new ScheduleModel())->where('class_id', $teacher['class_id'])->countAll()
        ];

        if ($teacher['class_id'] != null) {
            $data['class'] = (new ClassModel())->find($teacher['class_id']);
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

    public function getLessonsByDay()
    {

    }

    public function logout()
    {
        $this->session->remove('user');

        return redirect()->to(base_url('/'));
    }
}